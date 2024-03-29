<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>
<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Change your password') ?></h1>
            <?= form_open(route('changePasswordAction')) ?>
            <div class="field">
                <label class="label" for="user-password"><?=_('New password')?></label>
                <div class="control has-icons-left has-icons-right">
                    <input type="password" name="password" id="user-password" class="input" inputmode="text" autocomplete="off" placeholder="<?= _('New password') ?>" required value="">
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label for="user-password_confirm" class="label"><?= _('Confirm password') ?></label>
                <div class="control has-icons-left has-icons-right">
                    <input id="user-password_confirm" type="password" class="input" name="password_confirm" inputmode="text" autocomplete="off" placeholder="<?= _('Repeat the password') ?>" required value="" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="button is-primary"><?= _('Change password') ?></button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>