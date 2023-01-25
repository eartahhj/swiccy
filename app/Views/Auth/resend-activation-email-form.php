<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= _('Request a new activation email') ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Request a new activation email') ?></h1>

            <form action="<?= route('resend.activation.email.action') ?>" method="post">
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
                
                <div class="buttons">
                    <button type="submit" class="button is-primary"><?= _('Send') ?></button>
                </div>

            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
