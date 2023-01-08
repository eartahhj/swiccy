<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Email activation') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="box">
        <h1 class="title is-2"><?= _('Account activation') ?></h1>
        <?php if (session('error')) : ?>
            <div class="message">
                <div class="message-header">
                    <p><?= _('Error') ?></p>
                </div>
                <div class="message-body">
                    <?= session('error') ?>
                </div>
            </div>
        <?php endif ?>

        <p><?= _('We just sent an email to you with a code to confirm your email address. Copy that code and paste it below.') ?></p>

        <form action="<?= route('auth.verify') ?>" method="post" class="mt-3">
            <?= csrf_field() ?>

            <div class="field">
                <label for="email" class="label"><?=_('Code')?></label>
                <div class="control">
                    <input id="token" type="text" class="input" name="token" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" placeholder="000000" value="<?= old('token') ?>" required />
                </div>
            </div>

            <div class="buttons">
                <button type="submit" class="button is-primary"><?= _('Send') ?></button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
