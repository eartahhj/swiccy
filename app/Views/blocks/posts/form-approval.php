<?= form_open(route_to('admin.posts.approval')) ?>
<input type="hidden" name="_method" value="PUT" />
<input type="hidden" name="id" value="<?= $post->id ?>">
<?php if ($post->approved): ?>
    <input type="hidden" name="revoke" value="1">
    <button type="submit" onclick="return confirm('<?= _('Really revoke this post?') ?>')" class="button is-warning"><?= _('Revoke this post') ?></button>
<?php else: ?>
    <input type="hidden" name="approve" value="1">
    <button type="submit" onclick="return confirm('<?= _('Really approve this post?') ?>')" class="button is-success"><?= _('Approve this post') ?></button>
<?php endif ?>
<?= form_close() ?>