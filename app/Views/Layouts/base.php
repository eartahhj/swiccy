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
    <script type="text/javascript">
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['enableHeartBeatTimer', 15]);
        // _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
        var u="<?= env('matomo.host') ?>";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', <?= env('matomo.siteId') ?>]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
</head>
<body>
    <?php if ($showCookiePolicyBanner):?>
    <div id="cookie-policy-banner">
        <div class="container">
            <p><?= _('This website uses Matomo for statistics purposes. The data is anonymized by default and is stored in an European server controlled only by us. We do not share the data with third parties nor sell it to anyone.') ?></p>
            <p class="buttons">
                <button class="button" onclick="return closeCookieBanner();"><?= _('Close this message') ?></button>
                <a href="<?= page_url(4) ?>" class="button is-dark"><?= _('Read the full cookie policy') ?></a>
            </p>
        </div>
    </div>
    <?php endif?>
    <header id="header-main">
        <div class="container">
            <input type="checkbox" id="animations-switch-handler" role="switch" tabindex="0" class="sr-only"<?= ($animationsEnabled ? '' : ' checked="checked"')?> aria-labelled-by="animations-switch-handler-label">
            <label for="animations-switch-handler" class="sr-only" tabindex="-1">
                <span class="turn-on">
                    <?= _('Turn on animations') ?>
                </span>
                <span class="turn-off">
                    <?= _('Turn off animations')?>
                </span>
            </label>
            <div id="header-main-grid" class="grid">
                <div class="logo has-animation" aria-controls="animations-switch">
                    <a href="<?= route('home')?>">
                        <img src="/img/logo-notext.png" alt="<?= env('app.name') ?>" width="90" height="90" />
                    </a>
                    <p><?= env('app.name') ?></p>
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
                                <legend><?= _('Animations') ?></legend>
                                <label id="animations-switch-handler-label" for="animations-switch-handler" tabindex="-1" class="switch-handler-label">
                                    <span class="toggle">
                                        <span class="toggle-knob"></span>
                                    </span>
                                    <span class="off" aria-hidden="true"><?= _('Off') ?></span>
                                    <span class="on" aria-hidden="true"><?= _('On') ?></span>
                                </label>
                            </fieldset>
                        </div>
                        <div class="dropdown">
                            <input id="nav-language-handler" type="checkbox" tabindex="0" class="sr-only" aria-haspopup="true" aria-controls="nav-language-dropdown">
                            <label for="nav-language-handler" tabindex="-1" class="dropdown-trigger">
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
            <input type="checkbox" id="navbar-auth-handler" class="sr-only" tabindex="0">
            <div id="navbar-auth-user" class="navbar-start">
                <p><?= sprintf(_('You are logged in as %s'), $authUser->username) ?></p>
            </div>
            <nav id="navbar-auth-user-menu" class="navbar-end">
                <label for="navbar-auth-handler" tabindex="-1">
                    <span class="icon is-medium"></span>
                    <span class="text"><?= _('User menu') ?></span>
                    <span class="sr-only"><?= _('(Open/close the menu)') ?></span>
                </label>
                <ul class="navbar-brand">
                    <li>
                        <a href="<?= route('users.showMyPosts') ?>" class="navbar-item"><?= _('My posts') ?></a>
                    </li>
                    <li>
                        <a href="<?= route('users.showMyProfile') ?>" class="navbar-item"><?= _('My profile') ?></a>
                    </li>
                    <li>
                        <a href="<?= route('changePassword') ?>" class="navbar-item"><?= _('Change password') ?></a>
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
        <?= $this->include('blocks/alerts') ?>
        
        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>

        <?= $this->renderSection('pageScripts') ?>
    </main>
    <footer>
        <?php /*
        <span id="motion-element" class="has-animation can-hide"></span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="1.8 1.8 21.2 8.2">
            <path d="M 5 2 Q 1 1 2 5 Q 5 5 5 8 L 2 10 L 9 5 L 6 2 L 9 4 L 9 2 L 10 4 L 12 2 L 10 5 L 14 2 L 14 9 L 16 2 Q 14 8 17 9 L 18 2 Q 17 8 20 9 L 22 5 L 20 2 L 22 5 L 23 2" stroke="#000" stroke-width="0.1" fill="#fff"/>
        </svg>
        */?>
        <div class="container">
            <div class="grid">
                <div id="footer-col-1" class="logo logo-smaller">
                    <a href="<?=route('home')?>">
                        <img src="/img/logo.png" alt="<?=env('app.name')?> <?=_('Homepage')?>" width="64" height="64" />
                    </a>
                </div>
                <div id="footer-col-2" class="grid-col">
                    <nav class="languages-list">
                        <span><?=_('Change language')?></span>
                        <?= $this->include('blocks/languages-list') ?>
                    </nav>
                    <nav id="footer-policies">
                        <h2><?= _('Policies') ?></h2>
                        <ul>
                            <li>
                                <a href="<?= page_url(3) ?>"><?= _('Privacy policy') ?></a>
                            </li>
                            <li>
                                <a href="<?= page_url(4) ?>"><?= _('Cookie policy') ?></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <nav id="footer-col-3" class="grid-col">
                    <ul>
                        <li>
                            <span class="icon is-large" aria-hidden="true">
                                <i class="fab fa-github fa-3x"></i>
                            </span>
                            <a href="https://github.com/eartahhj/swiccy" rel="external noopener" target="_blank">
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
                            <a href="<?= page_url(2) ?>">
                                <?= sprintf(_('Buy me a %s coffee'), '<span aria-hidden="true">☕</span>') ?>
                            </a>
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
                            <a href="<?= page_url(1) ?>">
                                <?= _('Credits') ?>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <p id="footer-realized-by">&copy; <?=date('Y')?> <?=_('A project realized by')?> <a href="https://github.com/eartahhj" rel="external noopener nofollow" target="_blank">eartahhj</a></p>
        </div>
        <nav id="footer-bottom">
            <ul>
                <li>
                    <a href="<?= env('app.websiteAdmin') ?>" rel="external noopener"><?= _('Need a web developer? Hire me') ?></a>
                </li>
                <li>
                    <a href="mailto:<?= env('app.emailAdmin') ?>"><?= _('Want to advertise here? Email me') ?></a>
                </li>
            </ul>
        </nav>
    </footer>
</body>
</html>
