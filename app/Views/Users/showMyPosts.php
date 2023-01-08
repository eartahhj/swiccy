<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>
<?= _('Your posts') ?>
<?php $this->endSection()?>

<?= $this->section('content')?>

<div class="container">
    <h1 class="title is-2"><?= _('Your posts') ?></h1>
    <?php if (empty($posts)): ?>
    <p><?= _("You haven't submitted any posts yet!") ?></p>
    <p>
        <a href="<?= route('posts.new') ?>"><?= _('Create a post') ?></a>
    </p>
    <?php else:?>
        <ul>
            <?php foreach ($posts as $post):?>
            <li>
                <a href="<?= route('posts.show', $post->id) ?>"><?= esc($post->title) ?></a> (<?= sprintf(_('Approved: %s'), ($post->approved ? _('Yes') : _('No'))) ?>)
            </li>
            <?php endforeach ?>
        </ul>
    <?php endif?>
</div>

<?= $this->endSection() ?>