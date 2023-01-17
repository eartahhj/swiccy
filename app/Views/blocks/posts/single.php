<article>
    <h3 class="title is-5 mb-1">
        <a href="<?= route('posts.show', $post->id) ?>">
            <?=esc($post->title)?>
        </a>
    </h3>
    <p class="date mb-2"><?= sprintf(_('Posted at: %s'), formatDate($post->created_at)) ?></p>

    <?php if ($authUser):?>
    <p class="mt-2">
        <?php if ($post->user_id == $authUser->id):?>
            (<a href="<?= route('posts.edit', $post->id) ?>"><?= _('Edit your post') ?></a>)
        <?php endif?>
        <?php if ($authUser->inGroup('admin', 'superadmin')):?>
            (<a href="<?= route_to('admin.posts.edit', $post->id) ?>"><?= _('Manage this post') ?></a>)
        <?php endif?>
    </p>
    <?php endif?>
</article>