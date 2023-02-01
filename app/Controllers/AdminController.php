<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Entities\PageEntity;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\GroupModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminController extends BaseController
{
    private $posts = null;
    private $pages = null;

    public function __construct()
    {
        $this->posts = model(PostModel::class);
        $this->pages = model(PageModel::class);

        self::$templateStylesheets[] = '/css/panel.css';
    }

    public function index()
    {
        return view('Admin/index', ['pageTitle' => _('Administration')]);
    }

    public function posts()
    {
        $posts = $this->posts->paginate(20);

        return view('Admin/posts/index', ['posts' => $posts, 'pager' => $this->posts->pager, 'pageTitle' => _('Manage posts')]);
    }

    public function editPost(int $id)
    {
        $post = $this->posts->find($id);

        if (!$post) {
            // return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This post was not found')]));
            throw PageNotFoundException::forPageNotFound(_('This post was not found'));
        }

        if (!$this->user->inGroup('superadmin') and !$this->user->hasPermission('posts.edit')) {
            // return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This post was not found')]));
            throw PageNotFoundException::forPageNotFound(_('This post was not found'));
        }

        return view('Admin/posts/edit', ['post' => $post]);
    }

    public function updatePost()
    {
        return view('Admin/index', []);
    }

    public function deletePost()
    {
        return view('Admin/index', []);
    }

    public function approveRevokePost()
    {
        if (!$this->user->inGroup('superadmin') and !$this->user->hasPermission('posts.approval')) {
            return $this->response->setStatusCode(401)->setBody(view('errors/html/error_401', ['message' => _('Unauthorized access')]));
        }

        if ($this->request->getPost('approve') == 1) {
            $approved = true;
        } elseif ($this->request->getPost('revoke') == 1) {
            $approved = false;
        } else {
            return redirect()->back()->with('error', _('An error occured during the approve/revoke operation'));
        }

        $postId = $this->request->getPost('id');
        $post = $this->posts->find($postId);

        if (!$post) {
            throw PageNotFoundException::forPageNotFound(_('This post was not found'));
        }

        if ($this->posts->protect(false)->update($post->id, ['approved' => $approved]) === false) {
            return redirect()->back()->with('errors', $this->posts->errors());
        }

        if ($approved) {
            $message = sprintf(_('Post #%s has been approved'), $post->id);
        } else {
            $message = sprintf(_('Post #%s has been revoked'), $post->id);
        }

        return redirect()->back()->with('success', $message);
    }

    public function pages()
    {
        $pages = $this->pages->paginate(20);

        return view('Admin/pages/index', ['pages' => $pages, 'pager' => $this->pages->pager, 'pageTitle' => _('Manage pages')]);
    }

    public function createPageView()
    {
        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        return view('Admin/pages/new', ['templateJavascripts' => static::$templateJavascripts,
        'templateStylesheets' => static::$templateStylesheets, 'pageTitle' => _('New page')]);
    }

    public function createPageAction()
    {
        $userId = auth()->user()->id;

        $page = new PageEntity($this->request->getPost(['title_it', 'title_en', 'html_it', 'html_en', 'url_it', 'url_en']));
        $page->fill(['user_creator_id' => $userId]);

        foreach ($this->languages as $langCode => $langName) {
            if ($page->{'url_' . $langCode} === '') {
                $page->{'url_' . $langCode} = mb_url_title($page->{'title_' . $langCode}, '-', true);
            }
        }

        if (!$this->pages->protect(false)->insert($page)) {
            return redirect()->back()->with('errors', $this->pages->errors())->withInput();
        }

        return redirect()->to(url_to('admin.pages.new'))->with('success', _('Page created succesfully!'));
    }

    public function editPage(int $id)
    {
        $page = $this->pages->find($id);

        if (!$page) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }

        if (!$this->user->inGroup('superadmin') and !$this->user->hasPermission('pages.edit')) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }

        self::$templateJavascripts[] = '/js/tinymce/tinymce.min.js';
        self::$templateJavascripts[] = '/js/tinymce-init.js';

        return view('Admin/pages/edit', [
            'page' => $page,
            'templateJavascripts' => static::$templateJavascripts,
            'templateStylesheets' => static::$templateStylesheets,
            'pageTitle' => _('Edit page')
        ]);
    }

    public function updatePage()
    {
        $id = intval($this->request->getPost('id'));
        $page = $this->pages->find($id);
        $image = null;

        if (!$page) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }

        $page->fill($this->request->getPost(['title_it', 'title_en', 'html_it', 'html_en', 'url_it', 'url_en']));

        if (!$page->hasChanged()) {
            return redirect()->back()->with('info', _('No data has changed'))->withInput();
        }

        foreach ($this->languages as $langCode => $langName) {
            if ($page->{'url_' . $langCode} === '') {
                $page->{'url_' . $langCode} = mb_url_title($page->{'title_' . $langCode}, '-', true);
            }
        }

        if (!$this->pages->protect(false)->save($page)) {
            return redirect()->back()->with('errors', $this->pages->errors())->withInput();
        }

        return redirect()->to(url_to('admin.pages.edit', $page->id))->with('success', _('Page updated succesfully!'));
    }

    public function deletePage()
    {
        return view('Admin/index', []);
    }

    public function publishPage()
    {
        if (!$this->user->inGroup('superadmin') and !$this->user->hasPermission('pages.publish')) {
            return $this->response->setStatusCode(401)->setBody(view('errors/html/error_401', ['message' => _('Unauthorized access')]));
        }

        if ($this->request->getPost('publish') == 1) {
            $published = true;
        } elseif ($this->request->getPost('unpublish') == 1) {
            $published = false;
        } else {
            return redirect()->back()->with('error', _('An error occured during the approve/revoke operation'));
        }

        $pageId = $this->request->getPost('id');
        $page = $this->pages->find($pageId);

        if (!$page) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }

        if ($this->pages->protect(false)->update($page->id, ['published' => $published]) === false) {
            return redirect()->back()->with('errors', $this->pages->errors());
        }

        if ($published) {
            $message = sprintf(_('Page #%s has been published'), $page->id);
        } else {
            $message = sprintf(_('Page #%s has been unpublished'), $page->id);
        }

        return redirect()->back()->with('success', $message);
    }
}
