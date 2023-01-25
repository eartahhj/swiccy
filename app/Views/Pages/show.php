<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?= esc($page->{'title_' . $locale}) ?><?php $this->endSection()?>

<?= $this->section('content')?>

<section class="template-default template-standard">
    <div class="container">
        <?php if (!$page->published and $authUser and $authUser->inGroup('admin', 'superadmin')): ?>
            <div class="message is-warning">
                <div class="message-header"><?= _('Warning') ?></div>
                <div class="message-body"><?= _('This page has not been published yet, and is visible only to admins.') ?></div>
            </div>
        <?php endif?>

        <?php if ($authUser and $authUser->inGroup('admin', 'superadmin')): ?>
        <p class="buttons mb-5">
            <a href="<?= url_to('admin.pages.edit', $page->id)?>" class="button is-link"><?= _('Edit this page') ?></a>
        </p>
        <?php endif?>

        <article class="text">
            <?= $page->{'html_' . $locale} ?>
        </article>
    </div>
</section>

<?= $this->endSection() ?>