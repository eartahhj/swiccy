<?php
// Example library from course

namespace App\Libraries;

use App\Models\UserModel;

class Authentication
{
    private $user = null;

    public function login($email, $password)
    {
        $users = new UserModel();

        $user = $users->findByEmail($email);

        if ($user === null) {
            return false;
        }

        if (!$user->verifyPassword()) {
            return false;
        }

        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        if (!$this->user) {
            $users = new UserModel();
            $this->user = $users->find(session()->get('user_id'));   
        }

        return $this->user;
    }

    public function isLoggedIn()
    {
        return session()->has('user_id');
    }
}