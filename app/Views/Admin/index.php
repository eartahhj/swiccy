<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>
<section id="panel-index" class="template-default template-admin">
    <div class="container">
        <div class="box">
            <h1 class="title is-3"><?=_('Administration panel')?></h1>

            <h2 class="title is-5"><?= _('Users') ?></h2>
            <ul>
                <li>
                    <a href="<?= url_to('admin.users.index') ?>"><?= _('Manage users') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Posts') ?></h2>
            <ul>
                <li>
                    <a href="<?= url_to('admin.posts.index') ?>"><?= _('Manage posts') ?></a>
                </li>
            </ul>

            <h2 class="title is-5"><?= _('Pages') ?></h2>
            <ul>
                <li>
                    <a href="<?= url_to('admin.pages.index') ?>"><?= _('Manage pages') ?></a>
                </li>
                <li>
                    <a href="<?= url_to('admin.pages.new') ?>"><?= _('New page') ?></a>
                </li>
            </ul>
        </div>
    </div>
</section>

<?= $this->endSection() ?>