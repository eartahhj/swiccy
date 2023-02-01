<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('content') ?>
<section class="template-default template-standard">
    <div class="container">
        <h2 class="title is-2"><?= _('Magic link sent') ?></h5>

        <h3 class="title is-4"><?= _('Please check your email!') ?></h3>

        <p><?= sprintf(_('We just sent you an email with a Login link inside. It is only valid for %s minutes.'), setting('Auth.magicLinkLifetime') / 60) ?></p>
    </div>
</section>

<?= $this->endSection() ?>
