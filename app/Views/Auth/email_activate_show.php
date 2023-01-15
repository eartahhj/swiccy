<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Email activation') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Account activation') ?></h1>

            <?php if ($user): ?>
                <p><?= _('We just sent an email to you with a code to confirm your email address. Copy that code and paste it below.') ?></p>
            <?php else: ?>
                <p><?= _('Insert your email address and the code you received by email in order to activate your account.') ?></p>
                <p><?= _('You did not receive the code?') ?> <a href="<?= route('resend.activation.email') ?>"><?= _('Request a new code') ?></a></p>
            <?php endif ?>
            <form action="<?= route($user ? 'auth.verify' : 'activate.account.action') ?>" method="post" class="mt-3">
                <?= csrf_field() ?>

                <?php if (!$user): ?>
                <div class="field">
                    <label for="email" class="label"><?=_('Email')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="email" type="email" class="input" name="email" inputmode="email" autocomplete="email" placeholder="<?= _('Email address') ?>" value="<?= old('email', '') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>
                <?php endif?>

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
