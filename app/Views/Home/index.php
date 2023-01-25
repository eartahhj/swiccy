<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Homepage')?><?php $this->endSection()?>

<?= $this->section('content')?>

<div class="template-default template-homepage">
    <section id="swiccy-description">
        <div class="container">
            <h1 class="title is-2 mb-6"><?= _('Swiccy') ?></h1>
            <ol class="grid">
                <li>
                    <h2 class="title is-4"><?= _('What is Swiccy?') ?></h2>
                    <p><?= _('A posting platform where you can exchange goods with other people, free and privacy friendly.') ?></p>
                    <p><a href="<?= route('posts.new') ?>"><?= _('Start an exchange') ?></a></p>
                </li>
                <li>
                    <h2 class="title is-4"><?= _('Open source') ?></h2>
                    <p><?= _('This is an open-source project based on CodeIgniter 4.') ?></p>
                    <p><a href="#"><?= _('Discover on Github') ?></a></p>
                </li>
                <li>
                    <h2 class="title is-4"><?= _('Why use it?') ?></h2>
                    <p><?= _('Remember that old Nokia 3310 you have in your basement? It is time to exchange it for something else!') ?></p>
                </li>
                <li>
                    <h2 class="title is-4"><?= _('Recycle') ?></h2>
                    <p><?= _('You received a pair of *amazing* socks from your grandmother? Give them to someone else and you might receive back something better... like a Near-Mint 1st edition Charizard (yea, sure).') ?></p>
                </li>
            </ol>
        </div>
    </section>

    <section id="home-latest-posts">
        <div class="container">
            <h2 class="title is-3"><?= _('Latest posts') ?></h2>
            <?= $this->include('blocks/posts/latest') ?>
        </div>
    </section>

    <figure id="home-banner-boxes">
        <picture>
            <img src="/img/vector-boxes.webp" alt="" width="1446" height="971" loading="lazy">
            <source srcset="/img/vector-boxes.webp" sizes="1446w" media="screen" type="image/webp">
            <source srcset="/img/vector-boxes.png" sizes="1446w" media="screen" type="image/png">
        </picture>
    </figure>

    <section id="home-create-post">
        <div class="container">
            <h2 class="title is-3"><?= _('Create a new post') ?></h2>
            
            <?= $this->include('blocks/posts/form-create') ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>