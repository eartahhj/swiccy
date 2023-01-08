<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('New post')?><?php $this->endSection()?>

<?= $this->section('content')?>

<div class="container">
    <div class="box">
        <h1 class="title is-2"><?= _('Create a new post') ?></h1>
        
        <?= $this->include('blocks/posts/form-create') ?>
    </div>
</div>
<?= $this->endSection() ?>