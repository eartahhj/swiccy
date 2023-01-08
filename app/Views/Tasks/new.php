<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>New task<?php $this->endSection()?>

<?= $this->section('content')?>

<?= form_open('/tasks/create') ?>
<?php if (session()->has('errors')):?>
    <ul>
        <?php foreach (session('errors') as $error):?>
        <li><?=$error?></li>
        <?php endforeach?>
    </ul>
<?php endif?>
<div class="field">
    <label for="task-description">Description</label>
    <input type="text" name="description" id="task-description" value="<?=esc($task->description)?>">
</div>
<button type="submit">Save</button>
<?= form_close() ?>

<?= $this->endSection() ?>