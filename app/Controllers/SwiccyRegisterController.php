<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Events\Events;
use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\RegisterController;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

/**
 * Class RegisterController
 *
 * Handles displaying registration form,
 * and handling actual registration flow.
 */
class SwiccyRegisterController extends RegisterController
{

    /**
     * Displays the registration form.
     *
     * @return RedirectResponse|string
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', _('Registration is not allowed at this moment'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->to(route('auth.show'));
        }

        return view(setting('Auth.views')['register'], ['pageTitle' => _('Register')]);
    }

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', _('Registration is not allowed at this moment'));
        }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(
            setting('Auth.validFields'),
            setting('Auth.personalFields'),
            ['password']
        );
        $user = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            $route = route('auth.show');
            return redirect()->to($route);
        }

        // Set the user active
        $authenticator->activateUser($user);

        $authenticator->completeLogin($user);

        try {
            $email = service('email');
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo(env('email.defaultRecipient'));
            $email->setSubject('New user on Swiccy');
            $email->setMessage('A new user has registered on Swiccy. Username: ' . esc($user->username));
            $email->send();
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception} in [file] at [line]', ['exception' => $e]);
        }

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', _('Account registered with success!'));
    }

    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return string[]
     */
    protected function getValidationRules(): array
    {
        $registrationUsernameRules = array_merge(
            config('AuthSession')->usernameValidationRules,
            ['is_unique[users.username]']
        );
        $registrationEmailRules = array_merge(
            config('AuthSession')->emailValidationRules,
            ['is_unique[auth_identities.secret]']
        );

        return setting('Validation.registration') ?? [
            'username' => [
                'label' => 'Auth.username',
                'rules' => $registrationUsernameRules,
                'errors' => [
                    'is_unique' => _('This username has already been taken')
                ]
            ],
            'email' => [
                'label' => 'Auth.email',
                'rules' => $registrationEmailRules,
                'errors' => [
                    'is_unique' => _('This email has already been taken')
                ]
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required|strong_password',
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
        ];
    }
}
