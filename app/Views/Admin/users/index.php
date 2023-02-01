<?= $this->extend('Layouts/base') ?>

<?= $this->section('content')?>
<section class="template-default template-standard">
    <div class="container">
        <div class="box">
            <?php if (empty($users)):?>
                <h1 class="title is-2"><?=_('Nothing to show at the moment')?></h1>
            <?php else:?>
                <h1 class="title is-2"><?=_('Users')?></h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= _('ID') ?></th>
                            <th><?= _('Username') ?></th>
                            <th><?= _('Groups') ?></th>
                            <th><?= _('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user):?>
                        <tr>
                            <td>
                                <?= $user->id ?>
                            </td>
                            <td>
                                <a href="<?= route('users.show', $user->id) ?>">
                                    <?=esc($user->username)?>
                                </a>
                            </td>
                            <td>
                                <?= implode(', ', $user->getGroups()) ?>
                            </td>
                            <td>
                                <?= var_dump($user->inGroup('superadmin', 'admin')) ?>
                                <?= var_dump($authUser->hasPermission('users.edit')) ?>
                                <?php if (!$user->inGroup('superadmin', 'admin') and $authUser->hasPermission('users.edit')): ?>
                                    <a href="<?= url_to('admin.users.edit', $user->id) ?>">
                                        <span class="fa fa-edit">
                                            <span class="sr-only"><?= _('Edit this user') ?></span>
                                        </span>
                                    </a>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
                <?=$pager->links()?>
            <?php endif?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>