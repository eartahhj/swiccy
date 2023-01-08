<?php
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\LoginController;
use App\Controllers\ActionController;
use App\Controllers\RegisterController;
use App\Controllers\MagicLinkController;

$routes->group('admin', ['filter' => 'admin'], function() use ($routes) {
    $routes->get('/', [AdminController::class, 'index'], ['as' => 'admin.index']);

    $routes->get('users', [UserController::class, 'index'], ['as' => 'admin.users.index']);
    $routes->get('users/(:num)', [UserController::class, 'show/$1'], ['as' => 'admin.users.show']);
    $routes->put('users/edit/(:num)/groups', [AdminController::class, 'editUserGroups/$1'], ['as' => 'admin.users.edit.groups']);
    $routes->put('users/edit/(:num)/permissions', [AdminController::class, 'editUserPermissions/$1'], ['as' => 'admin.users.edit.permissions']);
    $routes->get('users/edit/(:num)', [AdminController::class, 'editUser/$1'], ['as' => 'admin.users.edit']);
    $routes->put('users/edit/(:num)', [AdminController::class, 'updateUser/$1'], ['as' => 'admin.users.update']);
    $routes->delete('users/delete/(:num)', [AdminController::class, 'deleteUser/$1'], ['as' => 'admin.users.delete']);

    $routes->get('posts', [AdminController::class, 'posts'], ['as' => 'admin.posts.index']);
    $routes->get('posts/(:num)', [PostController::class, 'show/$1'], ['as' => 'admin.posts.show']);
    $routes->get('posts/edit/(:num)', [AdminController::class, 'editPost/$1'], ['as' => 'admin.posts.edit']);
    $routes->put('posts/edit/(:num)', [AdminController::class, 'updatePost/$1'], ['as' => 'admin.posts.update']);
    $routes->put('posts/approval', [AdminController::class, 'approveRevokePost'], ['as' => 'admin.posts.approval']);
    $routes->delete('posts/delete/(:num)', [AdminController::class, 'deletePost/$1'], ['as' => 'admin.posts.delete']);

    $routes->get('pages', [AdminController::class, 'pages'], ['as' => 'admin.pages.index']);
    $routes->get('pages/(:num)', [PageController::class, 'show/$1'], ['as' => 'admin.pages.show']);
    $routes->get('pages/new', [AdminController::class, 'createPageView'], ['as' => 'admin.pages.new']);
    $routes->post('pages/create', [AdminController::class, 'createPageAction'], ['as' => 'admin.pages.create']);
    $routes->get('pages/edit/(:num)', [AdminController::class, 'editPage/$1'], ['as' => 'admin.pages.edit']);
    $routes->put('pages/edit/(:num)', [AdminController::class, 'updatePage/$1'], ['as' => 'admin.pages.update']);
    $routes->put('pages/publish', [AdminController::class, 'publishPage'], ['as' => 'admin.pages.publish']);
    $routes->delete('pages/delete/(:num)', [AdminController::class, 'deletePage/$1'], ['as' => 'admin.pages.delete']);
});

$routes->group('en', function() use ($routes) {
    $routes->get('/', [HomeController::class, 'index'], ['as' => 'en.home']);

    $routes->get('posts', [PostController::class, 'index'], ['as' => 'en.posts.index']);
    $routes->get('posts/new', [PostController::class, 'new'], ['as' => 'en.posts.new']);
    $routes->get('posts/(:num)', [PostController::class, 'show/$1'], ['as' => 'en.posts.show']);
    $routes->post('posts/create', [PostController::class, 'create'], ['as' => 'en.posts.create']);
    $routes->get('posts/edit/(:num)', [PostController::class, 'edit/$1'], ['as' => 'en.posts.edit']);
    $routes->put('posts/edit', [PostController::class, 'update'], ['as' => 'en.posts.update']);
    $routes->delete('posts/delete/(:num)', [PostController::class, 'delete/$1'], ['as' => 'en.posts.delete']);

    $routes->get('users/(:num)/posts', [UserController::class, 'showPostsForUser'], ['as' => 'en.posts.showUserPosts']);
    $routes->get('users/(:num)', [UserController::class, 'show/$1'], ['as' => 'en.users.show']);
    $routes->get('user/your-posts', [UserController::class, 'showMyPosts'], ['as' => 'en.users.showMyPosts']);
    $routes->get('user/profile', [UserController::class, 'showMyProfile'], ['as' => 'en.users.showMyProfile']);
    $routes->get('user/recover-password', [UserController::class, 'recoverPasswordView'], ['as' => 'en.recoverPassword']);
    $routes->post('user/recover-password', [UserController::class, 'recoverPasswordAction'], ['as' => 'en.recoverPasswordAction']);
    $routes->delete('user/delete-my-account', [UserController::class, 'deleteMyAccount'], ['as' => 'en.users.deleteMyAccount']);
    $routes->put('user/change-email', [UserController::class, 'changeEmailAction'], ['as' => 'en.user.change.email']);
    $routes->put('user/change-avatar', [UserController::class, 'changeAvatarAction'], ['as' => 'en.user.change.avatar']);


    $routes->get('login', [LoginController::class, 'loginView'], ['as' => 'en.login']);
    $routes->post('login', [LoginController::class, 'loginAction'], ['as' => 'en.login.create']);
    $routes->get('logout', [LoginController::class, 'logoutAction'], ['as' => 'en.logout']);

    $routes->get('register', [RegisterController::class, 'registerView'], ['as' => 'en.register']);
    $routes->post('register', [RegisterController::class, 'registerAction'], ['as' => 'en.register.create']);

    $routes->get('auth/a/show', [ActionController::class, 'show'], ['as' => 'en.auth.show']);
    $routes->post('auth/a/verify', [ActionController::class, 'verify'], ['as' => 'en.auth.verify']);
    $routes->post('auth/a/handle', [ActionController::class, 'handle'], ['as' => 'en.auth.handle']);
    
    $routes->get('login/magic-link', [MagicLinkController::class, 'loginView'], ['as' => 'en.magic.link']);
    $routes->post('login/magic-link', [MagicLinkController::class, 'loginAction'], ['as' => 'en.magic.link.action']);
    $routes->get('login/verify-magic-link', [MagicLinkController::class, 'verify'], ['as' => 'en.verify.magic.ink']);

    $routes->get('pages/(:alphanum)', [PageController::class, 'show'], ['as' => 'en.pages.show']);
});

$routes->group('it', function() use ($routes) {
    $routes->get('/', [HomeController::class, 'index'], ['as' => 'it.home']);

    $routes->get('annunci', [PostController::class, 'index'], ['as' => 'it.posts.index']);
    $routes->get('annunci/nuovo', [PostController::class, 'new'], ['as' => 'it.posts.new']);
    $routes->get('annunci/(:num)', [PostController::class, 'show/$1'], ['as' => 'it.posts.show']);
    $routes->post('annunci/crea', [PostController::class, 'create'], ['as' => 'it.posts.create']);
    $routes->get('annunci/modifica/(:num)', [PostController::class, 'edit/$1'], ['as' => 'it.posts.edit']);
    $routes->put('annunci/modifica', [PostController::class, 'update'], ['as' => 'it.posts.update']);
    $routes->delete('annunci/elimina/(:num)', [PostController::class, 'delete/$1'], ['as' => 'it.posts.delete']);

    $routes->get('utenti/(:num)/annunci', [UserController::class, 'showPostsForUser'], ['as' => 'it.posts.showPostsForUser']);
    $routes->get('utenti/(:num)', [UserController::class, 'show/$1'], ['as' => 'it.users.show']);
    $routes->get('utente/profilo', [UserController::class, 'showMyProfile'], ['as' => 'it.users.showMyProfile']);
    $routes->get('utente/i-tuoi-post', [UserController::class, 'showMyPosts'], ['as' => 'it.users.showMyPosts']);
    $routes->get('utente/recupera-password', [UserController::class, 'recoverPasswordView'], ['as' => 'it.recoverPassword']);
    $routes->post('utente/recupera-password', [UserController::class, 'recoverPasswordAction'], ['as' => 'it.recoverPasswordAction']);
    $routes->delete('utente/elimina-account', [UserController::class, 'deleteMyAccount'], ['as' => 'it.users.deleteMyAccount']);


    $routes->get('accedi', [LoginController::class, 'loginView'], ['as' => 'it.login']);
    $routes->post('accedi', [LoginController::class, 'loginAction'], ['as' => 'it.login.create']);
    $routes->get('esci', [LoginController::class, 'logoutAction'], ['as' => 'it.logout']);

    $routes->get('registrati', [RegisterController::class, 'registerView'], ['as' => 'it.register']);
    $routes->post('registrati', [RegisterController::class, 'registerAction'], ['as' => 'it.register.create']);

    $routes->get('auth/a/show', [ActionController::class, 'show'], ['as' => 'it.auth.show']);
    $routes->post('auth/a/verify', [ActionController::class, 'verify'], ['as' => 'it.auth.verify']);
    $routes->post('auth/a/handle', [ActionController::class, 'handle'], ['as' => 'it.auth.handle']);
    
    $routes->get('accedi/magic-link', [MagicLinkController::class, 'loginView'], ['as' => 'it.magic.link']);
    $routes->post('accedi/magic-link', [MagicLinkController::class, 'loginAction'], ['as' => 'it.magic.link.action']);
    $routes->get('accedi/verifica-magic-link', [MagicLinkController::class, 'verify'], ['as' => 'it.verify.magic.link']);

    $routes->get('pagine/(:alphanum)', [PageController::class, 'show'], ['as' => 'it.pages.show']);
});

// $routes->cli('migrate', 'MigrateController::index');