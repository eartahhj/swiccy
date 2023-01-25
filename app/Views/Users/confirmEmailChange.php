<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Email activation') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Confirm your new email') ?></h1>
            <p><?= _('We just sent an email to you with a code to confirm your email address. Copy that code and paste it below.') ?></p>
            <p><?= _('If you did not receive the code, please try again by editing your email in your profile.') ?> <a href="<?= route('users.showMyProfile') ?>"><?= _('Go to your profile') ?></a></p>
            
            <form action="<?= route('user.confirm.email.change.action') ?>" method="post" class="mt-3">
                <?= csrf_field() ?>

                <div class="field">
                    <label for="token" class="label"><?=_('Code')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="token" type="text" class="input" name="token" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" placeholder="000000" value="" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-hashtag"></i>
                        </span>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" class="button is-primary"><?= _('Send') ?></button>
                </div>

            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
