<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>Edit task<?php $this->endSection()?>

<?= $this->section('content')?>

<?= $this->include('Tasks/form')?>

<?php if ($task->id):?>
<form action="/tasks/delete/<?=$task->id?>" method="DELETE">
    <button type="submit">Delete</button>
</form>
<?php endif?>

<?= $this->endSection() ?>