<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>

<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?= _('Create a new post') ?></h1>
            
            <?= $this->include('blocks/posts/form-create') ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>