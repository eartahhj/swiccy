<?= form_open('/tasks/update/' . $task->id) ?>
<?php if (session()->has('errors')):?>
    <ul>
        <?php foreach (session('errors') as $error):?>
        <li><?=$error?></li>
        <?php endforeach?>
    </ul>
<?php endif?>
<div class="field">
    <label for="task-description"><?=_('Description')?></label>
    <input type="text" name="description" id="task-description" value="<?=old('description', esc($task->description))?>">
</div>

<input type="checkbox" name="hidden" id="task-hidden" value="1"<?=(old('hidden', 1) ? ' checked="checked"' : '')?>>

<input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>">
<button type="submit">Save</button>
<?= form_close() ?>