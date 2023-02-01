<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Controllers\MagicLinkController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class SwiccyMagicLinkController extends MagicLinkController
{
    public function verify(): RedirectResponse
    {
        $token = $this->request->getGet('token');

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityBySecret(Session::ID_TYPE_MAGIC_LINK, $token);

        $user = $this->provider->where('id', $identity->user_id)->first();

        if (!$user->active) {
            return redirect()->to(route('magic.link'))->with('error', _('Your account has not been activated yet. Please try to login first or request a new activation email.'));
        }

        return parent::verify();
    }

    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        return view(setting('Auth.views')['magic-link-login'], ['pageTitle' => _('Use a Login Link')]);
    }

    protected function displayMessage(): string
    {
        return view(setting('Auth.views')['magic-link-message'], ['pageTitle' => _('Use a Login Link')]);
    }
}