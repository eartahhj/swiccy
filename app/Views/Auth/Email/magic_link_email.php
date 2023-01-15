<h2><?= _('Someone has requested a Magic Login Link for your account at swiccy.it') ?></h2>
<p><?= _('If you did not request it, please ignore this message. Otherwise, click the following link.') ?></p>
<p>
    <a href="<?= substr(site_url(), 0, -1) . route('verify.magic.link') ?>?token=<?= $token ?>">
        <?= _('Log me in') ?>
    </a>
</p>
<p><?= sprintf(_('Not working? Try copying and pasting this in your browser: %s'), substr(site_url(), 0, -1) . route('verify.magic.link') . "?token={$token}") ?></p>
