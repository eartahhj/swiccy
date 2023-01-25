<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Manage pages')?><?php $this->endSection()?>

<?= $this->section('content')?>

<section class="template-default template-admin">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?=_('Manage pages')?></h1>

            <p class="buttons">
                <a href="<?= url_to('admin.pages.new') ?>" class="button is-link"><?= _('New page') ?></a>
            </p>

            <?php if (empty($pages)): ?>
                <h2><?= _('No pages to show at the moment') ?></h2>
            <?php else:?>
                <ul id="pages-list">
                <?php foreach ($pages as $page):?>
                    <li class="<?= ($page->published ? 'background-success' : 'background-warning') ?>">
                        <?= view('blocks/pages/item', compact('page')) ?>
                    </li>
                <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>