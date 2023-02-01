<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>

<section class="template-default template-standard">
    <div class="container">
        <h1 class="title is-2"><?=_('Edit your post')?></h1>

        <div class="message is-info">
            <div class="message-header"><?= _('Info') ?></div>
            <div class="message-body"><?= _('Please note that by editing your post, it will need to be approved again, therefore it will not be visible anymore until approved.') ?></div>
        </div>
        <div class="box">
            <?= view('blocks/posts/form-edit', compact('post')) ?>

            <div class="mt-2">
                <?= view('blocks/posts/form-delete', compact('post')) ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>