<article>
    <h2>
        <a href="<?= route_to('admin.pages.edit', $page->id) ?>">
        <?= esc($page->{'title_' . $locale}) ?>
        </a>
        (<a href="<?= route('pages.show', $page->id) ?>"><?= _('View this page') ?></a>)
    </h2>
    <p><?= sprintf(_('Published: %s'), $page->published ? _('Yes') : _('No')) ?></p>

    <?php if ($authUser->inGroup('admin', 'superadmin')):?>
    <?= view('blocks/pages/form-publish', compact('page')) ?>
    <?php endif?>
</article>