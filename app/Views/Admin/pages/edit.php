<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>

<section class="template-default template-admin">
    <div class="container">
        
        <div class="box">
            <h1 class="title is-2"><?=_('Edit page')?></h1>

            <?= view('blocks/pages/form-edit', compact('page')) ?>

            <div class="mt-2">
                <?= view('blocks/pages/form-delete', compact('page')) ?>
            </div>

            <div class="mt-2">
                <?= view('blocks/pages/form-publish', compact('page')) ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>