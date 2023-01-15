<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>
<?= _('Your profile') ?>
<?php $this->endSection()?>

<?= $this->section('content')?>

<section class="template-standard">
    <div class="container">
        <h1 class="title is-2"><?= _('Your profile') ?></h1>

        <h2 class="title is-5 mb-0"><?= _('Username') ?></h2>
        <p><?= esc($user->username) ?></p>

        <h2 class="title is-5 mt-5 mb-1"><?= _('Avatar') ?></h2>
        <figure>
            <img src="<?= esc($user->avatar()) ?>" alt="" width="100" height="100">
            <figcaption>
                <?= sprintf(_('You can change your avatar at %s'), '<a href="https://www.libravatar.org" rel="external noreferrer nofollow noopener" target="_blank">' . _('Libravatar') . '</a>') ?>
            </figcaption>
        </figure>
        
        <?php 
        /*
        <?= form_open_multipart(route('user.change.avatar')) ?>
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="field">
                <label for="avatar"><?= _('Your avatar') ?></label>
                <div class="control has-icons-left has-icons-right">
                    <input id="avatar" type="file" class="input" name="avatar" inputmode="file" autocomplete="email" placeholder="<?= _('Email address') ?>" required />
                    <span class="icon is-small is-left">
                        <i class="fas fa-photo"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="button is-link"><?= _('Save avatar') ?></button>
        <?= form_close() ?>
        */ ?>

        <h2 class="title is-5 mt-5 mb-2"><?= _('Email') ?></h2>
        <?= form_open(route('user.change.email')) ?>
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="field">
                <label for="email"><?= _('Your email address') ?></label>
                <div class="control has-icons-left has-icons-right">
                    <input id="email" type="email" class="input" name="email" inputmode="email" autocomplete="email" placeholder="<?= _('Email address') ?>" value="<?= old('email', $user->email) ?>" required />
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="button is-primary"><?= _('Save email') ?></button>
        <?= form_close() ?>


        <p class="mt-5 buttons">
            <a href="<?= route('changePassword') ?>" class="button is-link"><?= _('Change your password') ?></a>
            <?= form_open(route('users.deleteMyAccount')) ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="button is-danger" onclick="return confirm('Are you sure? All your data will be deleted, including your posts and uploaded images. This cannot be undone.')"><?= _('Delete your account') ?></button>
            <?= form_close() ?>
        </p>
    </div>
</section>

<?= $this->endSection() ?>