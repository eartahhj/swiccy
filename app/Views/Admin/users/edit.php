<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?>
<?= sprintf(_('User profile of %s'), esc($user->username)) ?>
<?php $this->endSection()?>

<?= $this->section('content')?>

<div class="container">
    <article>
        <h2 class="title is-3"><?= sprintf(_('Modifying user: %s'), esc($user->username)) ?></h2>
        <p><?= sprintf(_('User email: %s'), esc($user->email)) ?></p>

        <h3 class="title is-4 mt-5"><?= _('User groups')?></h3>
        <?= form_open(url_to('admin.users.edit.groups', $user->id))?>
            <input type="hidden" name="user_id" value="<?= $user->id ?>">
            <input type="hidden" name="_method" value="PUT">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= _('Assigned') ?></th>
                        <th><?= _('Group') ?></th>
                        <th><?= _('Description') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($allGroups as $groupName => $groupData):?>
                    <tr>
                        <td>
                            <input type="checkbox" name="groups[]" id="group-<?=$groupName?>" class="checkbox"<?= ($user->inGroup($groupName) ? 'checked="checked"' : '') ?> value="<?=$groupName?>">
                        </td>
                        <td>
                            <label for="group-<?=$groupName?>" class="checkbox"><?= $groupData['title'] ?></label>
                        </td>
                        <td>
                            <?= $groupData['description'] ?>
                        </td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>
            <p class="buttons">
                <button type="submit" class="button is-primary"><?= _('Save groups') ?></button>
            </p>
        </form>

        <h3 class="title is-4 mt-5"><?= _('User permissions')?></h3>
        <?= form_open(url_to('admin.users.edit.permissions', $user->id))?>
            <input type="hidden" name="user_id" value="<?= $user->id ?>">
            <input type="hidden" name="_method" value="PUT">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= _('Assigned') ?></th>
                        <th><?= _('Permission') ?></th>
                        <th><?= _('Description') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($allPermissions as $permissionName => $permissionDescription):?>
                    <tr>
                        <td>
                            <input type="checkbox" name="permissions[]" id="permission-<?=$permissionName?>" class="checkbox"<?= ($user->hasPermission($permissionName) ? 'checked="checked"' : '') ?> value="<?=$permissionName?>">
                        </td>
                        <td>
                            <label for="permission-<?=$permissionName?>" class="checkbox"><?= $permissionName ?></label>
                        </td>
                        <td>
                            <?= $permissionDescription ?>
                        </td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>
            <p class="buttons">
                <button type="submit" class="button is-primary"><?= _('Save permissions') ?></button>
            </p>
        </form>
    </article>

    <?php if ($authUser and $authUser->inGroup('admin', 'superadmin')):?>
    <p>
        <a href="<?= url_to('admin.users.index') ?>"><?= _('View all users') ?></a>
    </p>
    <?php endif ?>
</div>

<?= $this->endSection() ?>