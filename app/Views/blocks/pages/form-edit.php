<?= form_open_multipart(url_to('admin.pages.update', $page->id)) ?>
        <?php if (session()->has('errors')):?>
            <ul>
                <?php foreach (session('errors') as $error):?>
                <li><?=$error?></li>
                <?php endforeach?>
            </ul>
        <?php endif?>
        <?php foreach ($languages as $langCode => $lang):?>
        <fieldset>
            <legend><?= $lang ?></legend>

            <div class="field">
                <label class="label" for="page-title_<?=$langCode?>"><?= sprintf(_('Title (%s)'), $lang) ?> <?=_('*')?></label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" class="input" name="title_<?=$langCode?>" id="page-title_<?=$langCode?>" value="<?=old("title_{$langCode}", $page->{'title_' . $langCode})?>" minlength="5" maxlength="200" required="required" placeholder="" autocomplete="off">
                    <span class="icon is-small is-left">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                </div>
                <p class="help"><?=_('The title of the page should be below 60 characters')?></p>
            </div>

            <div class="field">
                <label class="label" for="page-html_<?=$langCode?>"><?= sprintf(_('HTML (%s)'), $lang) ?> <?=_('*')?></label>
                <div class="control">
                    <textarea class="tinymce" id="page-html_<?=$langCode?>" name="html_<?=$langCode?>" cols="30" rows="10"><?= old("html_{$langCode}", htmlentities($page->{'html_' . $langCode})) ?></textarea>
                </div>
                <p class="help"><?=_('Please consider writing the text in a SEO-friendly way.')?></p>
            </div>

            <div class="field">
                <label class="label" for="page-url_<?=$langCode?>"><?= sprintf(_('URL (%s)'), $lang) ?></label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" class="input" name="url_<?=$langCode?>" id="page-url_<?=$langCode?>" value="<?=old("url_{$langCode}", $page->{'url_' . $langCode})?>" minlength="5" maxlength="200" placeholder="" inputmode="text" autocomplete="off">
                    <span class="icon is-small is-left">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                </div>
                <p class="help"><?=_('The URL should be lowercase and separated by dashes, not spaces nor underscores')?></p>
            </div>
        </fieldset>
        <?php endforeach?>

        <input type="hidden" name="id" value="<?= $page->id ?>">
        <input type="hidden" name="_method" value="PUT">

        <div class="buttons mt-5">
            <button type="submit" class="button is-success"><?=_('Save')?></button>
        </div>
        <?= form_close() ?>