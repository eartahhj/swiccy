<?= form_open_multipart(route(($isUserLogged ? 'posts.create' : 'login'))) ?>
        <?php if (session()->has('errors')):?>
            <ul>
                <?php foreach (session('errors') as $error):?>
                <li><?=$error?></li>
                <?php endforeach?>
            </ul>
        <?php endif?>
        <fieldset>
            <legend><?= _('Exchange information') ?></legend>

            <div class="field">
                <label class="label" for="post-title"><?=_('What do you want to exchange?')?> <?=_('*')?></label>
                <div class="control has-icons-left has-icons-right">
                    <input type="text" class="input" name="title" id="post-title" value="<?=old('title', 'Lorem ipsum dolor')?>" minlength="5" maxlength="200" required="required" placeholder="<?= _('Pandoro from Christmas 2022') ?>" autocomplete="off">
                    <span class="icon is-small is-left">
                        <i class="fas fa-bullhorn"></i>
                    </span>
                </div>
                <p class="help"><?=_('Shortly describe the items you are giving away')?></p>
            </div>

            <div class="grid grid-form grid-2cols">
                <div class="field">
                    <label class="label" for="post-quantity-give"><?=_('Quantity to give')?> <?= _('*')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="number" class="input" name="quantity_give" id="post-quantity-give" value="<?=old('quantity_give', '1')?>" min="0" max="1000" step="1" required="required" placeholder="1" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-scale-balanced"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('How many items are you giving away?')?></p>
                </div>
                <div class="field">
                    <label class="label" for="post-quantity-receive"><?=_('Quantity to receive')?> <?= _('*')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="number" class="input" name="quantity_receive" id="post-quantity-receive" value="<?=old('quantity_receive', '1')?>" min="0" max="1000" step="1" required="required" placeholder="1" autocomplete="off">
                        <span class="icon is-small is-left">
                            <i class="fas fa-scale-balanced"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('How many would you like to receive in exchange?')?></p>
                </div>
            </div>

            <div class="field">
                <label class="label" for="post-text"><?=_('What would you like to receive?')?> <?=_('*')?></label>
                <div class="control">
                    <textarea class="textarea" id="post-text" name="text" cols="30" rows="10" minlength="10" maxlength="2000" required="required" placeholder="<?= _('Panettone with candied fruit') ?>" autocomplete="off"><?=old('text', 'Lorem ipsum dolor')?></textarea>
                </div>
                <p class="help"><?=_('Describe what items you are up to receive')?></p>
            </div>
        </fieldset>

        <fieldset>
            <legend><?= _('Location') ?></legend>
            <p class="help"><?= _('Where can the item(s) be found?') ?></p>

            <div class="grid grid-form grid-2cols">
                <div class="field">
                    <label class="label" for="post-city"><?=_('City')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="text" class="input" name="city" id="post-city" value="<?=old('city', 'Roma')?>" minlength="2" maxlength="200" required="required" placeholder="<?= _('City') ?>" autocomplete="address-line2">
                        <span class="icon is-small is-left">
                            <i class="fas fa-city"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('Which city can the item be found at?')?></p>
                </div>

                <div class="field">
                    <label class="label" for="post-address"><?=_('Address')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="text" class="input" name="address" id="post-address" value="<?=old('address', 'Via Roma 123')?>" minlength="5" maxlength="200" placeholder="<?= _('Street address') ?>" autocomplete="address-line1">
                        <span class="icon is-small is-left">
                            <i class="fas fa-map"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('You can specify an address if you want')?></p>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><?= _('Contact information') ?></legend>
            <p class="help"><?= _('Please specify how to contact you, either by email or phone') ?></p>

            <div class="grid grid-form grid-2cols">
                <div class="field">
                    <label class="label" for="post-email"><?=_('Email')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="email" class="input" name="email" id="post-email" value="<?= $email ?>" placeholder="example@example.com" required="required" minlength="6" maxlength="200" autocomplete="email">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('Your e-mail address')?></p>
                </div>

                <div class="field">
                    <label class="label" for="post-phone"><?=_('Phone number')?></label>
                    <div class="control has-icons-left has-icons-right">
                        <input type="tel" class="input" name="phone_number" id="post-phone" value="<?=old('phone_number', '1234567890')?>" minlength="5" maxlength="20" placeholder="" autocomplete="tel">
                        <span class="icon is-small is-left">
                            <i class="fas fa-phone"></i>
                        </span>
                    </div>
                    <p class="help"><?=_('Your phone number')?></p>
                </div>
            </div>
        </fieldset>

        <?php if ($isUserLogged):?>
        <div class="field">
            <div class="control file is-link has-name is-fullwidth">
                <label class="file-label" for="post-images">
                    <input class="file-input simp" type="file" name="images[]" id="post-images" multiple accept="image/*"  data-preview-container-selector="#images-previews" data-names-container-selector="#file-names" />
                    <span class="file-cta">
                        <span class="file-icon">
                        <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                        <?= _('Choose images to upload') ?>
                        </span>
                    </span>
                    <span id="file-names" class="file-name">
                        <?= _('Browse...') ?>
                    </span>
                </label>
            </div>
            <p class="help"><?= _('You can select up to 5 images. Supported Formats: JPEG, PNG, WEBP or AVIF. Maximum dimensions: 1000x1000px. Maximum size for each image: 500KB.') ?></p>
            <div id="images-previews" class="images-preview"></div>
        </div>
        <?php endif?>


        <div class="field">
            <p class="mb-3"><?= _('Please note that by sending this post, you acknowledge that it must be legal, and that the responsibility is fully on you.') ?></p>
            <label class="checkbox">
                <input type="checkbox" required="required">
                <?= _('I declare that the exchange I am posting is 100% legal, and I take full responsibility for it.') ?>
            </label>
        </div>

        <div class="buttons mt-5">
            <button type="submit" class="button is-dark"><?=_('Post')?></button>
        </div>
        <?= form_close() ?>