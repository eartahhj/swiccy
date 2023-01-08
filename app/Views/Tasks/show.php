<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>Task <?=$task->id?><?php $this->endSection()?>

<?= $this->section('content')?>

<p><?=_('Remove Task obsolete 151222_1357')?> <?=$task->id?></p>
<p><?=_('Description')?>: <?=esc($task->description)?></p>

<?= $this->endSection() ?>