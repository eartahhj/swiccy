<!DOCTYPE html>
<html lang="<?= $locale ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | <?=env('app.name')?></title>

    <link rel="preload" href="/assets/fontawesome/css/all.min.css" as="style">
    <link rel="preload" href="/css/bulma/bulma.min.css" as="style">
    <link rel="preload" href="/css/style.css" as="style">
    <?php if ($authUser and $authUser->inGroup('admin', 'superadmin')): ?>
    <link rel="preload" href="/css/adminbar.css" as="style">
    <?php endif?>

    <?php if (!empty($templateStylesheets)):?>
        <?php foreach ($templateStylesheets as $css):?>
            <link rel="preload" href="<?=$css?>" as="style">
        <?php endforeach?>
    <?php endif?>

    <?php if (!empty($templateJavascripts)):?>
        <?php foreach ($templateJavascripts as $js):?>
            <link rel="preload" href="<?=$js?>" as="script">
        <?php endforeach?>
    <?php endif?>

    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
    <link href="/css/bulma/bulma.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css" title="Default">

    <?php if ($authUser and $authUser->inGroup('admin', 'superadmin')): ?>
    <link rel="stylesheet" href="/css/adminbar.css" title="Default">
    <?php endif?>

    <link rel="shortcut icon" href="/img/favicon.png">

    <script>
        var locale = '<?= htmlspecialchars($locale) ?>';
        var loginRoute = '<?= htmlspecialchars(route('login')) ?>';
    </script>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/global.js"></script>

    <?php if (!empty($templateStylesheets)):?>
        <?php foreach ($templateStylesheets as $css):?>
            <link href="<?=$css?>" rel="stylesheet">
        <?php endforeach?>
    <?php endif?>

    <?php if (!empty($templateJavascripts)):?>
        <?php foreach ($templateJavascripts as $js):?>
            <script src="<?=$js?>"></script>
        <?php endforeach?>
    <?php endif?>

    <?= $this->renderSection('pageStyles') ?>

    <?= $this->renderSection('pageJavascripts') ?>
</head>
<body>
    <header id="header-main">
        <div class="container">
            <input type="checkbox" id="logo-animation-switch-handler" role="switch" tabindex="0" class="sr-only"<?= ($logoAnimation ? '' : ' checked="checked"')?> aria-labelled-by="logo-animation-switch-handler-label">
            <label for="logo-animation-switch-handler" class="sr-only">
                <span class="turn-on">
                    <?= _('Turn on logo animation') ?>
                </span>
                <span class="turn-off">
                    <?= _('Turn off logo animation')?>
                </span>
            </label>
            <div id="header-main-grid" class="grid">
                <div class="logo" aria-controls="logo-animation-switch">
                    <a href="<?= route('home')?>">
                        <img src="/img/logo-notext.png" alt="<?= env('app.name') ?>" width="90" height="90" />
                    </a>
                </div>
                <nav id="nav-main" class="navbar">
                    <ul class="navbar-start">
                        <li>
                            <a href="<?= route('posts.index') ?>" class="navbar-item"><?= _('All posts') ?></a>
                        </li>
                        <li>
                            <a href="<?= route('posts.new') ?>" class="navbar-item"><?= _('New post') ?></a>
                        </li>
                        <?php if (!$authUser):?>
                        <li>
                            <a href="<?= route('login') ?>" class="navbar-item"><?= _('Login') ?></a>
                        </li>
                        <li>
                            <a href="<?= route('register') ?>" class="navbar-item"><?= _('Register') ?></a>
                        </li>
                        <?php endif?>
                    </ul>
                    <div class="navbar-end">
                        <div class="switch">
                            <fieldset>
                                <legend><?= _('Logo animation') ?></legend>
                                <label id="logo-animation-switch-handler-label" for="logo-animation-switch-handler" tabindex="-1" class="switch-handler-label">
                                    <span class="toggle">
                                        <span class="toggle-knob"></span>
                                    </span>
                                    <span class="off" aria-hidden="true"><?= _('Off') ?></span>
                                    <span class="on" aria-hidden="true"><?= _('On') ?></span>
                                </label>
                            </fieldset>
                        </div>
                        <div class="dropdown">
                            <input id="nav-language-handler" type="checkbox" tabindex="-1" class="sr-only" aria-haspopup="true" aria-controls="nav-language-dropdown">
                            <label for="nav-language-handler" tabindex="0" class="dropdown-trigger">
                                <span class="text"><?=_('Change language')?></span>
                                <span class="icon"></span>
                            </label>
                            <div id="nav-language-dropdown" class="dropdown-menu">
                                <nav class="dropdown-content">
                                    <?= $this->include('blocks/languages-list') ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <?php if ($isUserLogged):?>
    <section id="navbar-auth" class="navbar">
        <div class="container">
            <div id="navbar-auth-user" class="navbar-start">
                <p><?= sprintf(_('You are logged in as %s'), $authUser->username) ?></p>
            </div>
            <nav id="navbar-auth-user-menu" class="navbar-end">
                <ul class="navbar-brand">
                    <li>
                        <a href="<?= route('users.showMyPosts') ?>" class="navbar-item"><?= _('My posts') ?></a>
                    </li>
                    <li>
                        <a href="<?= route('users.showMyProfile') ?>" class="navbar-item"><?= _('My profile') ?></a>
                    </li>
                    <li>
                        <a href="<?= route('recoverPassword') ?>" class="navbar-item"><?= _('Change password') ?></a>
                    </li>
                    <li>
                        <a href="<?= route('logout') ?>" class="navbar-item"><?= _('Logout') ?></a>
                    </li>
                    <?php if ($authUser->inGroup('admin', 'superadmin')):?>
                        <li>
                            <a href="<?= route_to('admin.index') ?>" class="navbar-item"><?= _('Administration') ?></a>
                        </li>
                        <?php if ($authUser->inGroup('superadmin') or $authUser->hasPermission('posts.edit')):?>
                        <li>
                            <a href="<?= route_to('admin.posts.index') ?>" class="navbar-item"><?= _('Manage posts') ?></a>
                        </li>
                        <?php endif?>
                        <?php if ($authUser->inGroup('superadmin') or $authUser->hasPermission('pages.edit')):?>
                        <li>
                            <a href="<?= route_to('admin.pages.index') ?>" class="navbar-item"><?= _('Manage pages') ?></a>
                        </li>
                        <?php endif?>
                        <?php if ($authUser->inGroup('superadmin') or $authUser->hasPermission('users.edit')):?>
                        <li>
                            <a href="<?= route_to('admin.users.index') ?>" class="navbar-item"><?= _('Manage users') ?></a>
                        </li>
                        <?php endif?>
                    <?php endif?>
                </ul>
            </nav>
        </div>
    </section>
    <?php endif?>
    <main id="main-content">
        <div class="page-alerts">
            <div class="container">
                <?= $this->include('blocks/alerts') ?>
                <?= $this->renderSection('pageAlerts') ?>
            </div>
        </div>

        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>

        <?= $this->renderSection('pageScripts') ?>
    </main>
    <footer>
        <div class="container">
            <div class="grid">
                <div class="logo logo-smaller">
                    <a href="<?=route('home')?>">
                        <img src="/img/logo.png" alt="<?=env('app.name')?> <?=_('Homepage')?>" width="64" height="64" />
                    </a>
                </div>
                <nav class="grid-col languages-list">
                    <span><?=_('Change language')?></span>
                    <?= $this->include('blocks/languages-list') ?>
                </nav>
                <nav id="footer-links" class="grid-col">
                    <ul>
                        <li>
                            <span class="icon is-large" aria-hidden="true">
                                <i class="fab fa-github fa-3x"></i>
                            </span>
                            <a href="#" rel="external noopener" target="_blank">
                                Github
                                <span class="sr-only"><?= _('(opens in a new window)') ?></span>
                            </a>
                            <span class="icon is-small" aria-hidden="true">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </li>
                        <li>
                            <span class="icon icon-custom icon-donate is-large" aria-hidden="true">
                            </span>
                            <a href="#" rel="noopener" target="_blank">
                                Buy me a <span aria-hidden="true">☕</span> coffee
                                <span class="sr-only"><?= _('(opens in a new window)') ?></span>
                            </a>
                            <span class="icon is-small" aria-hidden="true">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </li>
                        <li>
                            <span class="icon icon-custom icon-gaminghouse is-large" aria-hidden="true">
                            </span>
                            <a href="https://www.gaminghouse.community" rel="external noopener" target="_blank">
                                GamingHouse
                                <span class="sr-only"><?= _('(opens in a new window)') ?></span>
                            </a>
                            <span class="icon is-small" aria-hidden="true">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </li>
                        <li>
                            <span class="icon is-large" aria-hidden="true">
                                <i class="fa-brands fa-creative-commons-by fa-3x"></i>
                            </span>
                            <a href="<?= route('pages.show', 1) ?>">
                                <?= _('Credits') ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <p id="footer-realized-by" class="mt-3">&copy; <?=date('Y')?> <?=_('A project realized by')?> <a href="https://github.com/eartahhj" rel="external noopener nofollow" target="_blank">eartahhj</a></p>
        </div>
    </footer>
</body>
</html>
