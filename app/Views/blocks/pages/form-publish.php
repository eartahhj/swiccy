<?= form_open(route_to('admin.pages.publish')) ?>
<input type="hidden" name="_method" value="PUT" />
<input type="hidden" name="id" value="<?= $page->id ?>">
<?php if ($page->published): ?>
    <input type="hidden" name="unpublish" value="1">
    <button type="submit" onclick="return confirm('<?= _('Really unpublish this page?') ?>')" class="button is-warning"><?= _('Unpublish this page') ?></button>
<?php else: ?>
    <input type="hidden" name="publish" value="1">
    <button type="submit" onclick="return confirm('<?= _('Really publish this page?') ?>')" class="button is-success"><?= _('Publish this page') ?></button>
<?php endif ?>
<?= form_close() ?>