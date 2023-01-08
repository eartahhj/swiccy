<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Administration')?><?php $this->endSection()?>

<?= $this->section('content')?>

<div class="container">
    <div class="box">
        <h1><?=_('Administration panel')?></h1>

        <h2><?= _('Users') ?></h2>
        <ul>
            <li>
                <a href="<?= url_to('admin.users.index') ?>"><?= _('Manage users') ?></a>
            </li>
        </ul>

        <h2><?= _('Posts') ?></h2>
        <ul>
            <li>
                <a href="<?= url_to('admin.posts.index') ?>"><?= _('Manage posts') ?></a>
            </li>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>