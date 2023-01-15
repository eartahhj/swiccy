<?php

namespace App\Controllers;

use App\Models\PostModel;

class HomeController extends BaseController
{
    private $posts = null;

    public function __construct()
    {
        $this->posts = model(PostModel::class);
    }

    public function languageRedirect()
    {
        return redirect()->to($this->request->getLocale());
    }

    // public function testTwig()
    // {
    //     return $this->twig->render('Home/index', ['a' => 'b']);
    // }

    public function index()
    {

        $latestPosts = $this->posts->where('approved = 1')->orderBy('created_at', 'desc')->findAll(8);

        self::$templateStylesheets[] = '/css/home.css';
        $user = null;
        $email = '';

        if (!auth()->loggedIn()) {
            self::$templateJavascripts[] = '/js/form-redirect-login.js';
        } else {            
            self::$templateJavascripts[] = '/js/simpjs/simp.js';
            self::$templateJavascripts[] = '/js/simpjs/simp-init.js';
            self::$templateStylesheets[] = '/js/simpjs/simp.css';
            
            $user = auth()->user();

            $email = $user->email ?? '';
        }
        
        return view('Home/index', compact('latestPosts', 'user', 'email') + ['templateJavascripts' => static::$templateJavascripts, 'templateStylesheets' => static::$templateStylesheets]);
        // return $this->parser->setData(compact('latestPosts', 'user', 'email'))->render('Home/index');
    }
}
