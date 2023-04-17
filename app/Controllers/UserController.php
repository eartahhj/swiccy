<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Entities\UserEntity;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Shield\Authentication\Actions\EmailActivator;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

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

    public function show(int $id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This user was not found')]));
        }

        $pageTitle = sprintf(_('User profile of %s'), esc($user->username));

        return view('Users/show', compact('user', 'pageTitle'));
    }

    public function showPostsForUser(int $id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        $posts = model(PostModel::class)->where('user_id', $user->id)->findAll();

        $pageTitle = sprintf(_('Posts made by %s'), esc($user->username));

        return view('Users/showPostsForUser', compact('user', 'pageTitle'));
    }

    public function showMyPosts()
    {
        $user = auth()->user();

        $posts = model(PostModel::class)->where('user_id', $user->id)->findAll();

        $pageTitle = _('Your posts');

        return view('Users/showMyPosts', compact('posts', 'pageTitle'));
    }

    public function changePasswordView()
    {
        return view('Auth/changePassword', ['pageTitle' => _('Change your password')]);
    }

    public function changePasswordAction()
    {
        $user = auth()->user();

        $data = $this->request->getPost(['password', 'password_confirm']);

        if (!$this->validate([
            'password' => 'required|strong_password',
            'password_confirm' => 'required|matches[password]'
        ])) {
            return redirect()->back()->with('error', _('The passwords do not match'));
        }

        $user->password = $data['password'];
        $user->saveEmailIdentity();

        return redirect()->to(route('users.showMyProfile'))->with('success', _('Password updated!'));
    }

    public function showMyProfile()
    {
        $user = auth()->user();

        $pageTitle = _('Your profile');

        return view('Users/showMyProfile', compact('user', 'pageTitle'));
    }

    private function sendConfirmationEmailToUser(User $user, string $userEmail = ''): bool
    {
        if (!$userEmail) {
            if (!$user->email) {
                throw new RuntimeException(_('Could not determine user email'));
                return false;
            }
        }

        $activator = new EmailActivator();
        $code = $activator->createIdentity($user);

        $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $email->setTo($userEmail);
        $email->setSubject(lang('Auth.emailActivateSubject'));
        $email->setMessage(view(setting('Auth.views')['action_email_activate_email'], ['code' => $code]));

        if ($email->send(false) === false) {
            throw new RuntimeException(sprintf(_('Cannot send email to: %s', $userEmail)) . "\n" . $email->printDebugger(['headers']));
            return false;
        }
        
        $email->clear();
        
        return true;
    }

    public function activateAccountView()
    {
        if (auth()->user() and auth()->user()->active) {
            return redirect()->to(route('home'))->with('info', _('Your account is already active. If you need to activate another account, please logout first.'));
        }

        // This uses the same default view of Shield, but here the user session has expired
        return view(setting('Auth.views')['action_email_activate_show'], ['user' => null, 'pageTitle' => _('Email activation')]);
    }

    public function changeEmailAction()
    {
        $user = auth()->user();

        $email = $this->request->getPost('email');

        if ($email == $user->email) {
            return redirect()->back()->with('info', _('You are already using this email!'));
        }

        if (!$this->validate([
            'email' => 'is_unique[auth_identities.secret]'
        ])) {
            return redirect()->back()->with('error', _('This email has already been taken'));
        }

        if (!$this->sendConfirmationEmailToUser($user, $email)) {
            throw new RuntimeException(_('There was an error sending the activation email.'));
        }

        session()->set('newEmail', $email);

        return redirect()->to(route('user.confirm.email.change.view'))->with('info', _('Please insert the code you received by email to activate your new email address.'));
    }

    public function confirmEmailChangeView()
    {
        if (!session()->get('newEmail')) {
            throw PageNotFoundException::forPageNotFound(_('The new email was not set in the session'));
        }

        return view('Users/confirmEmailChange', ['pageTitle' => _('Email activation')]);
    }

    public function confirmEmailChangeAction()
    {
        $token = $this->request->getPost('token');
        $newEmail = session()->get('newEmail');
        $user = auth()->user();

        if (!$token) {
            throw PageNotFoundException::forPageNotFound(_('Token was not set'));
        }

        if (!$newEmail) {
            throw PageNotFoundException::forPageNotFound(_('The new email was not set in the session'));
        }

        $userEntity = new UserEntity(['id' => $user->id]);
        $identity = $userEntity->getIdentity(Session::ID_TYPE_EMAIL_ACTIVATE);

        if ($identity->secret != $token) {
            return redirect()->back()->with('error', _('We could not verify your new email address, please double check that the code you entered is correct.'));
        }

        $userIdentityModel = model(UserIdentityModel::class);
        $userIdentityModel->deleteIdentitiesByType($user, $identity->type);

        session()->remove('newEmail');

        $user->email = $newEmail;
        $this->users->save($user);

        try {
            $email = service('email');
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($newEmail);
            $email->setSubject('Your new email has been verified');
            $email->setMessage('Someone has confirmed to be the owner of this email on Swiccy. If you did not request this, please consider that someone might be using your email adress.');
            $email->send();
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception} in [file] at [line]', ['exception' => $e]);
        }

        return redirect()->to(route('users.showMyProfile'))->with('success', _('Your new email address has been confirmed successfully!')); 
    }

    protected function updateUserEmail(User $user, string $email)
    {
        $user->email = $email;
        $user->saveEmailIdentity();

        return redirect()->to(route('users.showMyProfile'))->with('success', _('Email updated!'));
    }

    public function requestActivationEmailView()
    {
        return view('Auth/resend-activation-email-form', ['pageTitle' => _('Request a new activation email')]);
    }

    public function requestActivationEmailAction()
    {
        $email = $this->request->getPost('email');

        if (!$email) {
            return redirect()->to(route('resend.activation.email'));
        }

        return $this->resendConfirmationEmailToUserByEmail($email);
    }

    public function resendConfirmationEmailToUserByEmail(string $email)
    {
        $user = $this->users->findByCredentials(['email' => $email]);

        $message = _('If there is an account associated to the email you have entered, we just sent an activation code there. Please insert it below to activate your account.');

        if (!$user or ($user and $user->active)) {
            return redirect()->to(route('activate.account.view'))->with('success', $message);
        }

        if (!$this->sendConfirmationEmailToUser($user, $email)) {
            throw new RuntimeException(_('There was an error sending the activation email.'));
        }

        return redirect()->to(route('activate.account.view', $user))->with('success', $message);
    }

    public function activateUserByCode()
    {
        $token = $this->request->getPost('token');
        $email = $this->request->getPost('email');

        if (!$token) {
            throw PageNotFoundException::forPageNotFound(_('Token was not set'));
        }

        $user = $this->users->findByCredentials(['email' => $email]);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        $userEntity = new UserEntity(['id' => $user->id]);
        $identity = $userEntity->getIdentity(Session::ID_TYPE_EMAIL_ACTIVATE);
        
        if ($identity->secret != $token) {
            return redirect()->back()->with('error', _('We could not verify your new email address, please double check that the code you entered is correct.'));
        }

        $userIdentityModel = model(UserIdentityModel::class);
        $userIdentityModel->deleteIdentitiesByType($user, $identity->type);

        $user->active = true;
        $this->users->save($user);

        try {
            $email = service('email');
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($newEmail);
            $email->setSubject('Your account has been activated');
            $email->setMessage('Someone has activated an account, associated to this email, on Swiccy. If you did not request this, please consider that someone might be using your email adress.');
            $email->send();
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception} in [file] at [line]', ['exception' => $e]);
        }

        return redirect()->to(route('login'))->with('success', _('Your account has been verified succesfully!'));
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

        if ($user->id != auth()->user()) {
            return $this->response->setStatusCode(401)->setBody(view('errors/html/error_401', ['message' => _('Unauthorized access')]));
        }

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
