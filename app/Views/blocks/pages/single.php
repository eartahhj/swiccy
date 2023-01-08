<article>
    <h3 class="title is-5 mb-1">
        <a href="<?= route('pages.show', $page->id) ?>">
            <?=esc($page->{'title_' . $locale})?>
        </a>
    </h3>
    <p class="date mb-2"><?= sprintf(_('Written at: %s'), $page->created_at) ?></p>

    <?php if ($authUser):?>
    <p class="mt-2">
        <?php if ($authUser->inGroup('admin', 'superadmin')):?>
            (<a href="<?= route_to('admin.pages.edit', $page->id) ?>"><?= _('Manage this page') ?></a>)
        <?php endif?>
    </p>
    <?php endif?>
</article>