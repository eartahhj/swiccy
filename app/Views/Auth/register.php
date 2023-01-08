<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Register') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Register') ?></h1>

            <form action="<?= route('register') ?>" method="post">
                <?= csrf_field() ?>

                <div class="field">
                    <label for="email" class="label"><?= _('Email') ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="email" type="email" class="input" name="email" inputmode="email" autocomplete="email" placeholder="<?= _('Email address') ?>" value="<?= old('email') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label for="username" class="label"><?= _('Username') ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="username" type="text" class="input" name="username" autocomplete="username" placeholder="<?= _('Username') ?>" value="<?= old('username') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label"><?= _('Password') ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="password" class="input" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= _('Password') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label for="password_confirm" class="label"><?= _('Confirm password') ?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="password" class="input" name="password_confirm" inputmode="text" autocomplete="current-password" placeholder="<?= _('Repeat the password') ?>" required />
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>                    

                <div class="buttons">
                    <button type="submit" class="button is-primary"><?= _('Register') ?></button>
                </div>

                <p class="text-center"><?= _('Already registered?') ?> <a href="<?= route('login') ?>"><?= _('Login') ?></a></p>

            </form>
        </div>
    </div>

<?= $this->endSection() ?>

