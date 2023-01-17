<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\ImageModel;
use App\Entities\PostEntity;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class PostController extends BaseController
{
    private $posts = null;

    public function __construct()
    {
        $this->posts = model(PostModel::class);
    }

    public function index()
    {
        $posts = $this->posts->where('approved', 1)->paginate(20);

        return view('Posts/index', ['posts' => $posts, 'pager' => $this->posts->pager]);
    }

    public function show(int $id)
    {
        $post = $this->posts->find($id);

        if (!$post) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This post was not found')]));
        }

        if (!$post->approved and $post->user_id != auth()->user()->id) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This post was not found')]));
        }

        $users = model(UserModel::class);
        $author = $users->where('id', $post->user_id)->first();

        $imagesModel = model(ImageModel::class);
        $images = $imagesModel->where('post_id', $post->id)->find();

        return view('Posts/show', compact('post', 'author', 'images'));
    }

    public function new()
    {
        $user = null;
        $email = '';

        if (!auth()->loggedIn()) {
            self::$templateJavascripts[] = '/js/form-redirect-login.js';
        } else {            
            self::$templateJavascripts[] = '/js/simpjs/simp.js';
            self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
            self::$templateStylesheets[] = '/js/simpjs/simp.css';

            if (auth()->user()) {
                $user = auth()->user();
            }

            if (old('email')) {
                $email = old('email');
            } else {
                $email = $user->email ?? '';
            }
        }

        return view('Posts/new', [
            'post' => new PostEntity(),
            'templateJavascripts' => static::$templateJavascripts,
            'templateStylesheets' => static::$templateStylesheets,
            'user' => $user,
            'email' => $email
        ]);
    }

    public function create()
    {
        $images = null;

        if ($_FILES['images']['size'][0] !== 0) {
            $numberOfUploadedImages = count($_FILES['images']['size']);

            if ($numberOfUploadedImages > 5) {
                return redirect()->back()->with('error', _('You can select a maximum of 5 images.'))->withInput();
            }

            $images = $this->request->getFileMultiple('images');
        }
        
        if ($images and !$this->validate(
            [
                'images[]' => 'uploaded[images]|max_dims[images,1000,1000]|max_size[images,500]|is_image[images]|mime_in[images,image/jpeg,image/png,image/webp,image/avif]|ext_in[images,jpg,jpeg,png,webp,avif]'
            ],
            [
                'images[]' => [
                    'max_dims' => _('The images can be maximum 1000x1000px'),
                    'max_size' => _('The images can have a maximum size of 500KB each'),
                    'is_image' => _('The file you uploaded seems not to be an image'),
                    'mime_in' => _('Some types of files you selected are not allowed'),
                    'ext_in' => _('Some types of files you selected are not allowed')
                ]
            ]
        )) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $userId = auth()->user()->id;

        $post = new PostEntity($this->request->getPost(['title', 'text', 'city', 'email', 'phone_number', 'address', 'quantity_give', 'quantity_receive']));
        $post->fill(['user_id' => $userId, 'language' => $this->language]);

        if (!$this->posts->protect(false)->insert($post)) {
            return redirect()->back()->with('errors', $this->posts->errors())->withInput();
        }

        if ($images) {
            $imageModel = model(ImageModel::class);
            if (!$imageModel->uploadImagesForPost($images, $this->posts->getInsertID())) {
                return redirect()->back()->with('error', _('There was an error uploading images. Please check the files are valid and try again.'))->withInput();
            }
        }
        
        try {
            $email = service('email');
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo(env('email.defaultRecipient'));
            $email->setSubject('New post on Swiccy');
            $email->setMessage('A new post was sent on Swiccy. Title: ' . esc($post->title));
            $email->send();
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception} in [file] at [line]', ['exception' => $e]);
        }

        return redirect()->to(route('posts.index'))->with('success', _('Post created succesfully!'));
    }

    public function edit(int $id)
    {
        $post = $this->posts->find($id);

        if (!$post) {
            throw new PageNotFoundException(_('Post not found'));
        }

        if ($post->user_id != auth()->user()->id and !auth()->user()->inGroup('superadmin')) {
            throw new PageNotFoundException(_('Unauthorized operation'));
        }
        
        $images = model(ImageModel::class);
        $postImages = $images->where('post_id', $post->id)->find();

        return view('Posts/edit', compact('post', 'postImages'));
    }

    public function update()
    {
        $id = intval($this->request->getPost('id'));
        $post = $this->posts->find($id);
        $images = null;
        
        if (!$post) {
            throw new PageNotFoundException(_('Post not found'));
        }

        if (!auth()->user()->inGroup('superadmin') && ($post->user_id != auth()->user()->id)) {
            throw new PageNotFoundException(_('Unauthorized action'));
        }

        if ($_FILES['images']['size'][0] !== 0) {
            $images = $this->request->getFileMultiple('images');
        }
        
        if ($images and !$this->validate(
            [
                'images[]' => 'uploaded[images]|max_dims[images,1000,1000]|max_size[images,800]|is_image[images]|mime_in[images,image/jpeg,image/png,image/webp,image/avif]|ext_in[images,jpg,jpeg,png,webp,avif]'
            ],
            [
                'images[]' => [
                    'max_dims' => _('The images can be maximum 1000x1000px'),
                    'max_size' => _('The images can have a maximum size of 500KB each'),
                    'is_image' => _('The file you uploaded seems not to be an image'),
                    'mime_in' => _('Some types of files you selected are not allowed'),
                    'ext_in' => _('Some types of files you selected are not allowed')
                ]
            ]
        )) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $post->fill($this->request->getPost(['title', 'text', 'city', 'email', 'phone_number', 'address', 'quantity_give', 'quantity_receive']));
        // Revoke post approval on edit, we want it to be approved manually again
        $post->approved = false;

        if (!$post->hasChanged() and !$images) {
            return redirect()->back()->with('info', _('No data has changed'))->withInput();
        }

        if (!$this->posts->protect(false)->save($post)) {
            return redirect()->back()->with('errors', $this->posts->errors())->withInput();
        }

        if ($images) {
            $imageModel = model(ImageModel::class);

            if (!$imageModel->removeImagesForPost($post->id)) {
                return redirect()->back()->with('error', _('There was an error removing the old images for this post.'))->withInput();
            }

            if (!$imageModel->uploadImagesForPost($images, $post->id)) {
                return redirect()->back()->with('error', _('There was an error uploading images. Please check the files are valid and try again.'))->withInput();
            }
        }

        try {
            $message = "
            A post has been edited on Swiccy. ID: {$post->id}, Title: " . esc($post->title) . '
            <a href="' .  url_to('admin.posts.edit', $post->id) . '">View post</a>';
            $email = service('email');
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo(env('email.defaultRecipient'));
            $email->setSubject('A post was edited on Swiccy');
            $email->setMessage($message);
            $email->send();
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception} in [file] at [line]', ['exception' => $e]);
        }

        return redirect()->to(route('posts.index'))->with('success', _('Post updated succesfully!'));
    }

    public function delete(int $id)
    {
        $post = $this->posts->find($id);

        if (!$post) {
            throw new PageNotFoundException(_('Post not found'));
        }

        if ($post->user_id != auth()->user()->id) {
            throw new PageNotFoundException(_('Unauthorized action'));
        }

        $imageModel = model(ImageModel::class);
        $images = $imageModel->where('post_id', $post->id)->find();
        
        if (!empty($images)) {
            foreach ($images as $image) {
                $imagesIds[$image->id] = $image->id;
                $imagesFileNames[$image->id] = $image->filename;
            }

            if (!$imageModel->whereIn('id', $imagesIds)->delete()) {
                return redirect()->back()->with('error', _('Error deleting images for this post'))->withInput();
            }

            foreach ($imagesFileNames as $fileName) {
                if (!is_file(WRITEPATH . 'uploads/' . $fileName)) {
                    continue;
                }

                unlink(WRITEPATH . 'uploads/' . $fileName);
            }
        }

        if (!$this->posts->delete($id)) {
            return redirect()->back()->with('error', _('Error deleting post'))->withInput();
        }

        return redirect()->to(route('posts.index'))->with('info', _('Post deleted'));
    }
}
