<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>
<section class="template-default template-standard">
    <div class="container">
        <h1 class="title is-2"><?= _('Your posts') ?></h1>
        <?php if (empty($posts)): ?>
        <p><?= _("You haven't submitted any posts yet!") ?></p>
        <p>
            <a href="<?= route('posts.new') ?>"><?= _('Create a post') ?></a>
        </p>
        <?php else:?>
            <ul id="posts-list">
                <?php foreach ($posts as $post):?>
                <li>
                    <a href="<?= route('posts.show', $post->id) ?>"><?= esc($post->title) ?></a> (<?= sprintf(_('Approved: %s'), ($post->approved ? _('Yes') : _('No'))) ?>)
                </li>
                <?php endforeach ?>
            </ul>
        <?php endif?>
    </div>
</section>

<?= $this->endSection() ?>