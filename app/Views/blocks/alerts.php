<div class="container">
    <?php if (session()->has('errors')):?>
    <div class="message is-danger">
        <div class="message-header"><?=_('Errors')?></div>
        <div class="message-body">
            <ul>
            <?php foreach(session('errors') as $error):?>
                <li>
                    <?=$error?>
                </li>
            <?php endforeach?>
            </ul>
        </div>
    </div>
    <?php endif?>

    <?php if (session()->has('error')):?>
        <div class="message is-danger">
            <div class="message-header"><?= _('Error') ?></div>
            <div class="message-body">
                <?= session('error') ?>
            </div>
        </div>
    <?php endif?>

    <?php if (session()->has('warning')):?>
        <div class="message is-warning">
            <div class="message-header"><?= _('Warning') ?></div>
            <div class="message-body">
                <?= session('warning') ?>
            </div>
        </div>
    <?php endif?>

    <?php if (session()->has('info')):?>
        <div class="message is-info">
            <div class="message-header"><?= _('Info') ?></div>
            <div class="message-body">
                <?= session('info') ?>
            </div>
        </div>
    <?php endif?>

    <?php if (session()->has('message')):?>
        <div class="message is-info">
            <div class="message-header"><?= _('Info') ?></div>
            <div class="message-body">
                <?= session('message') ?>
            </div>
        </div>
    <?php endif?>

    <?php if (session()->has('success')):?>
        <div class="message is-success">
            <div class="message-header"><?= _('Success') ?></div>
            <div class="message-body">
                <?= session('success') ?>
            </div>
        </div>
    <?php endif?>
</div>