<?= form_open(route_to('admin.pages.delete', $page->id)) ?>
<input type="hidden" name="_method" value="DELETE" />
<input type="hidden" name="id" value="<?= $page->id ?>">
<button type="submit" onclick="return confirm('<?= _('Really delete this page?') ?>')" class="button is-danger"><?= _('Delete this page') ?></button>
<?= form_close() ?>