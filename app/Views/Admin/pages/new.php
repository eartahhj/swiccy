<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>

<section class="template-default template-admin">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Create a new page') ?></h1>
            
            <?= $this->include('blocks/pages/form-create') ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>