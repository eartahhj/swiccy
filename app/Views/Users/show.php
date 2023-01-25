<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>
<?= sprintf(_('User profile of %s'), esc($user->username)) ?>
<?php $this->endSection()?>

<?= $this->section('content')?>

<section class="template-default template-standard">
    <div class="container">
        <article>
            <figure>
                <img src="<?= esc($user->avatar()) ?>" alt="" width="100" height="100">
            </figure>
            <h2 class="title is-3"><?= esc($user->username) ?></h2>
        </article>

        <?php if ($authUser and $authUser->inGroup('admin', 'superadmin')):?>
        <p class="mt-5">
            <a href="<?= url_to('admin.users.index') ?>"><?= _('View all users') ?></a>
        </p>
        <?php endif ?>

        <?php if ($authUser and $authUser->inGroup('superadmin')):?>
        <p class="mt-5">
            <a href="<?= url_to('admin.users.edit', $user->id) ?>"><?= _('Edit user') ?></a>
        </p>
        <?php endif ?>
        
    </div>
</section>

<?= $this->endSection() ?>