<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

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

    public function show(string $uri)
    {
        if (!isPageUrlFormatValid(url: $uri)) {
            throw PageNotFoundException::forPageNotFound(_('Invalid Page URL Format'));
        }        

        if (!$id = getPageIdByUrl(url: $uri)) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }
        
        $page = $this->pages->find($id);

        if (!$page) {
            throw PageNotFoundException::forPageNotFound(_('This page was not found'));
        }

        $stringUrl = getPageUrlByUri($uri);

        if ($page->{'url_' . $this->language} != $stringUrl) {
            $redirect = url_to($this->language . '.pages.show', $page->id . '-' . $page->{'url_' . $this->language});
            return redirect()->to($redirect);
        }

        if (!$page->published) {
            if (!auth()->user() or (auth()->user() and !auth()->user()->inGroup('admin', 'superadmin'))) {
                return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This page was not found')]));
            }
        }

        $users = model(UserModel::class);
        $author = $users->where('id', $page->user_creator_id)->first();

        $pageTitle = esc($page->{'title_' . $this->language});

        return view('Pages/show', compact('page', 'author', 'pageTitle'));
    }
}
