<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>Tasks<?php $this->endSection()?>

<?= $this->section('content')?>

<h1><?=_('Tasks')?></h1>
<?php if (!$tasks):?>
    <p><?=_('No tasks to show')?></p>
<?php else:?>
    <ul>
    <?php foreach($tasks as $task):?>
        <li>
            <a href="/task/<?=$task->id?>">Task <?=$task->id?></a>
            <?=$task->description?>
        </li>
    <?php endforeach?>
    </ul>
<?php endif?>

<?=$pager->links()?>

<?= $this->endSection() ?>