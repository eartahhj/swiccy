<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Posts')?><?php $this->endSection()?>

<?= $this->section('content')?>

<div class="template-default template-standard">
    <div class="container">
        <h1 class="title is-2"><?=_('Posts')?></h1>
        <?php if (empty($posts)):?>
        <p><?=_('Nothing to show at the moment')?></p>
        <?php else:?>
        <div class="elements-list" id="posts-list">
            <ul>
            <?php foreach($posts as $post):?>
                <li>
                    <?= view('blocks/posts/single', ['post' => $post]) ?>
                </li>
            <?php endforeach?>
            </ul>
            <?=$pager->links()?>
        </div>
    <?php endif?>
    </div>
</div>

<?= $this->endSection() ?>