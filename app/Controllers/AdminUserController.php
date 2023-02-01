<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminUserController extends BaseController
{
    private $users = null;

    public function __construct()
    {
        $this->users = model(UserModel::class);
    }

    public function index()
    {
        $users = $this->users->paginate(20);

        return view('Admin/users/index', ['users' => $users, 'pager' => $this->users->pager, 'pageTitle' => _('Manage users')]);
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

    public function edit(int $id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        if (!auth()->user()->inGroup('superadmin') and !$this->user->hasPermission('users.edit')) {
            // return $this->response->setStatusCode(404)->setBody(view('errors/html/error_404', ['message' => _('This user was not found')]));
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        $groups = model(GroupModel::class);
        $userGroups = $groups->getForUser($user);
        $allGroups = config('AuthGroups')->groups;
        $allPermissions = config('AuthGroups')->permissions;
        $pageTitle = sprintf(_('Modify user profile of %s'), esc($user->username));

        return view('Admin/users/edit', compact('user', 'userGroups', 'allGroups', 'allPermissions', 'pageTitle'));
    }

    public function editGroups(int $userId)
    {
        $user = $this->users->find($userId);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        if (!auth()->user()->inGroup('superadmin') and !$this->user->hasPermission('users.edit')) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        $groups = $this->request->getPost('groups');
        
        if (!$user->syncGroups(...$groups)) {
            return redirect()->back()->with('error', _('There was an error updating the groups'))->withInput();
        } else {
            return redirect()->back()->with('success', _('Groups updated!'));
        }
    }

    public function editPermissions(int $userId)
    {
        $user = $this->users->find($userId);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        if (!auth()->user()->inGroup('superadmin') and !$this->user->hasPermission('users.edit')) {
            throw PageNotFoundException::forPageNotFound(_('This user was not found'));
        }

        $permissions = $this->request->getPost('permissions');
        
        if (!$user->syncPermissions(...$permissions)) {
            return redirect()->back()->with('error', _('There was an error updating the permissions'))->withInput();
        } else {
            return redirect()->back()->with('success', _('Permissions updated!'));
        }
    }
}
