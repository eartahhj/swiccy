<?php if (!$latestPosts): ?>
    <h3><?= _('No posts to show at the moment')?></h3>
<?php else: ?>
    <ul class="grid">
    <?php foreach ($latestPosts as $post): ?>
        <li>
            <?= view('blocks/posts/single', ['post' => $post]) ?>
        </li>
    <?php endforeach?>
    </ul>
<?php endif?>
    