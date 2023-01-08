<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('New page')?><?php $this->endSection()?>

<?= $this->section('content')?>

<div class="container">
    <div class="box">
        <h1 class="title is-2"><?= _('Create a new page') ?></h1>
        
        <?= $this->include('blocks/pages/form-create') ?>
    </div>
</div>
<?= $this->endSection() ?>