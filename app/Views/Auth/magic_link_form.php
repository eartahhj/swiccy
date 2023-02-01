<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('content') ?>
<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Use a Magic Link to login') ?></h1>
            <p><?= _('Please insert your email, you will receive a link to login.') ?></p>
            <form action="<?= route('magic.link') ?>" method="post" class="mt-4">
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

                <p class="buttons">
                    <button type="submit" class="button is-primary"><?= _('Send') ?></button>
                </p>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
