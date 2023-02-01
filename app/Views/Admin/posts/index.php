<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>
<section class="template-default template-admin">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?=_('Manage posts')?></h1>

            <?php if (empty($posts)): ?>
                <h2><?= _('No posts to show at the moment') ?></h2>
            <?php else:?>
                <ul id="posts-list">
                <?php foreach ($posts as $post):?>
                    <li class="<?= ($post->approved ? 'background-success' : 'background-warning') ?>">
                        <?= view('blocks/posts/item', compact('post')) ?>
                    </li>
                <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>