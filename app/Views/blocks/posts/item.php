<article>
    <h2>
        <a href="<?= route('posts.show', $post->id) ?>">
        <?= esc($post->title) ?>
        </a>
    </h2>
    <p><?= nl2br(esc($post->text)) ?></p>
    <p><?= sprintf(_('Approved: %s'), $post->approved ? _('Yes') : _('No')) ?></p>

    <?php if ($authUser->inGroup('admin', 'superadmin')):?>
    <?= view('blocks/posts/form-approval', compact('post')) ?>
    <?php endif?>
</article>