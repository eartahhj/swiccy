<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Use a Login Link') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="box">
        <h1 class="title is-2"><?= _('Use a Magic Link to login') ?></h1>
        <p><?= _('Please insert your email, you will receive a link to login.') ?></p>
        <form action="<?= route('magic.link') ?>" method="post" class="mt-4">
            <?= csrf_field() ?>

            <div class="field">
                <div class="control">
                    <label for="email" class="label"><?= _('Email') ?></label>
                    <input type="email" class="input" name="email" autocomplete="email" id="email" placeholder="<?= _('Email') ?>" value="<?= old('email', auth()->user()->email ?? null) ?>" required />
                </div>
            </div>

            <p class="buttons">
                <button type="submit" class="button is-primary"><?= _('Send') ?></button>
            </p>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
