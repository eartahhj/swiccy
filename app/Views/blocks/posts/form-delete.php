<?= form_open(route('posts.delete', $post->id)) ?>
<input type="hidden" name="_method" value="DELETE" />
<input type="hidden" name="id" value="<?= $post->id ?>">
<button type="submit" onclick="return confirm('<?= _('Really delete this post?') ?>')" class="button is-danger"><?= _('Delete this post') ?></button>
<?= form_close() ?>