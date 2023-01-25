<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Login') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Login') ?></h1>

            <form action="<?= route('login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="field">
                    <label for="email" class="label"><?=_('Email')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="email" type="email" class="input" name="email" inputmode="email" autocomplete="email" placeholder="<?= _('Email address') ?>" value="<?= old('email', '') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label"><?= _('Password') ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="password" type="password" class="input" name="password" autocomplete="current-password" placeholder="<?= _('Password') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>
                
                <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')): ?> checked="checked"<?php endif ?>>
                                <?= _('Keep me logged in with this browser') ?>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="buttons">
                    <button type="submit" class="button is-primary"><?= _('Login') ?></button>
                </div>

                <p>
                    <?= _('Forgot your credentials?') ?> <a href="<?= route('magic.link') ?>"><?= _('Use a magic link') ?></a>
                    - <?= _('Not activated yet?') ?> <a href="<?= route('activate.account.view') ?>"><?= _('Verify your account') ?></a>
                <?php if (setting('Auth.allowRegistration')): ?>
                    - <?= _("Don't have an account?") ?> <a href="<?= route('register') ?>"><?= _('Register') ?></a>
                <?php endif ?>
                </p>

            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
