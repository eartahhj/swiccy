<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    private $pages = null;

    public function __construct()
    {
        $this->pages = model(PageModel::class);
    }

    public function index()
    {
        //
    }

    public function show(int $id)
    {
        $page = $this->pages->find($id);

        if (!$page) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This page was not found')]));
        }

        if (!$page->published and auth()->user() and !auth()->user()->inGroup('admin', 'superadmin')) {
            return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This page was not found')]));
        }

        $users = model(UserModel::class);
        $author = $users->where('id', $page->user_id)->first();

        return view('pages/show', compact('page', 'author'));
    }
}
