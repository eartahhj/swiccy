<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Edit page')?><?php $this->endSection()?>

<?= $this->section('content')?>

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

<?= $this->endSection() ?>