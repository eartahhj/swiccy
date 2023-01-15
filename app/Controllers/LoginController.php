<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\Authentication;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends BaseController
{
    // protected $helpers = ['setting', 'route'];

    public function index()
    {
        return view('Login/index');
    }

    public function create()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $auth = service('auth');

        if ($auth->login($email, $password)) {
            return redirect()->to('/login')->with('info', 'Logged in!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Invalid credentials');
        }

        // $users = new UserModel();

        // $user = $users->where('email', $email)->first();

        // if ($user === null) {
        //     return redirect()->back()->withInput()->with('warning', 'Email not found');
        // }

        // if (password_verify($password, $user->password_hash)) {
        //     $session = session();
        //     $session->regenerate();
        //     $session->set('user_id', $user->id);
        //     return redirect()->to('/login')->with('info', 'Logged in!');
        // }
    }

    public function delete()
    {
        $auth = service('auth')->logout();

        return redirect()->to()->with('info', 'Logout successful!');
    }

    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        if (service('request')->getGet('redirect') == 'formhome') {
            session()->setFlashdata('warning', _('To post something you need to login or register'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            $route = route('auth.show');
            return redirect()->to($route);
        }

        return view(setting('Auth.views')['login']);
    }

    public function loginAction(): RedirectResponse
    {
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $credentials             = $this->request->getPost(setting('Auth.validFields'));
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->to(route('login'))->withInput()->with('error', $result->reason());
        }

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->to(route('auth.show'))->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    protected function getValidationRules(): array
    {
        return setting('Validation.login') ?? [
            // 'username' => [
            //     'label' => 'Auth.username',
            //     'rules' => config('AuthSession')->usernameValidationRules,
            // ],
            'email' => [
                'label' => 'Auth.email',
                'rules' => config('AuthSession')->emailValidationRules,
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required',
            ],
        ];
    }

    public function logoutAction(): RedirectResponse
    {
        auth()->logout();

        return redirect()->to(route('home'))->with('message', _('You have been logged out!'));
    }
}
