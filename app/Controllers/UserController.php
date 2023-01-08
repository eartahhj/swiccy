<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;

class UserController extends BaseController
{
    private $users = null;

    public function __construct()
    {
        $this->users = model(UserModel::class);
        $this->groups = '';
    }
    
    public function create()
    {
        $user = new User();
    }

    public function index()
    {
        $users = $this->users->paginate(20);

        return view('Users/index', ['users' => $users, 'pager' => $this->users->pager]);
    }

    public function show(int $id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This user was not found')]));
        }

        return view('Users/show', compact('user'));
    }

    public function showPostsForUser(int $id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            throw new PageNotFoundException(_('This user was not found'));
        }

        $posts = model(PostModel::class)->where('user_id', $user->id)->findAll();

        return view('Users/showPostsForUser', compact('user'));
    }

    public function showMyPosts()
    {
        $user = auth()->user();

        $posts = model(PostModel::class)->where('user_id', $user->id)->findAll();

        return view('Users/showMyPosts', compact('posts'));
    }

    public function recoverPasswordView()
    {
        return view('Auth/recoverPassword');
    }

    public function recoverPasswordAction()
    {
        $user = auth()->user();

        $data = $this->request->getPost(['password', 'password_confirm']);
        $user->password = $data['password'];
        $user->saveEmailIdentity();

        return redirect()->to(route('users.showMyProfile'))->with('success', _('Password updated!'));
    }

    public function showMyProfile()
    {
        $user = auth()->user();

        return view('Users/showMyProfile', compact('user'));
    }

    public function changeEmailAction()
    {
        $user = auth()->user();

        $email = $this->request->getPost('email');
        $user->email = $data['email'];
        $user->saveEmailIdentity();

        return redirect()->to(route('users.showMyProfile'))->with('success', _('Email updated!'));
    }

    public function changeAvatarAction()
    {
        // 2023-01-08:
        // For now the avatar comes from Libravatar
        // Maybe in the future we give the change to customize the avatar differently

        $user = auth()->user();

        // $avatar = $this->request->getFile('avatar');
        // // TODO: Upload
        // $user->save();

        // return redirect()->to(route('users.showMyProfile'))->with('success', _('Avatar updated!'));
    }

    public function deleteMyAccount()
    {
        $user = auth()->user();
        $postModel = model(PostModel::class);
        $imageModel = model(ImageModel::class);

        $userPosts = $postModel->where('user_id', $user->id)->findAll();

        if (!empty($userPosts)) {
            foreach ($userPosts as $post) {
                $postIds[$post->id] = $post->id;
            }
    
            $postsImages = $imageModel->whereIn('post_id', $postIds)->find();
            
            if (!empty($postsImages)) {
                foreach ($postsImages as $image) {
                    if (!is_file(WRITEPATH . 'uploads/' . $image->filename)) {
                        continue;
                    }
    
                    unlink(WRITEPATH . 'uploads/' . $image->filename);
                }
            }
        }

        $this->users->delete($user->id, true);        

        return redirect()->to(route('home'))->with('success', _('Your account has been deleted succesfully!'));
    }
}
