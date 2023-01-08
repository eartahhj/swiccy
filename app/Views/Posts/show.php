<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?= esc($post->title) ?><?php $this->endSection()?>

<?= $this->section('content')?>
<section class="template-post">
    <div class="container">
        <?php if (!$post->approved and $post->user_id == auth()->user()->id): ?>
            <div class="message is-warning">
                <div class="message-header"><?= _('Warning') ?></div>
                <div class="message-body"><?= _('This post has not been approved yet, and is visible only to you.') ?></div>
            </div>
        <?php endif?>

        <article>
            <h2 class="title is-3"><?= esc($post->title) ?></h2>
            
            <div class="grid grid-7-3">
                <div class="grid-col">
                    <h3 class="title is-5"><?= _('Post details') ?></h3>
                    <span><?= sprintf(_('Quantity to give: %s'), intval($post->quantity_give)) ?> <?= sprintf(_('Quantity to receive: %s'), intval($post->quantity_receive)) ?></span>
                    <p><?= nl2br(esc($post->text)) ?></p>
                </div>
                <aside class="grid-col">
                    <h3 class="title is-5"><?= _('Contact information') ?></h3>
                    <a href="<?= route('users.show', $author->id) ?>">
                        <figure>
                            <img src="<?= esc($author->avatar()) ?>" alt="" width="100" height="100">
                        </figure>
                        <?= esc($author->username) ?>
                    </a>
                    <dl class="mt-5">
                        <dt><?= _('Email') ?></dt>
                        <dd><?= esc($post->email) ?></dd>
                        <?php if ($post->phone_number):?>
                        <dt><?= _('Phone number') ?></dt>
                        <dd><a href="tel:<?= esc($post->phone_number) ?>"><?= esc($post->phone_number) ?></a></dd>
                        <?php endif?>
                    </dl>

                    <?php if ($post->city or $post->address): ?>
                    <h3 class="title is-5"><?= _('Location') ?></h3>
                    <dl>
                        <?php if ($post->city):?>
                        <dt><?= _('City') ?></dt>
                        <dd><?= esc($post->city) ?></dd>
                        <?php endif?>
                        <?php if ($post->address):?>
                        <dt><?= _('Address') ?></dt>
                        <dd>
                            <p><?= esc($post->address) ?></p>
                            <p><a href="https://maps.google.com/?q=<?=urlencode(esc($post->address) . ($post->city ? ' ' . esc($post->city) : ''))?>" rel="external noopener noreferrer nofollow" target="_blank"><?= _('View on Google Maps') ?></a>, <a href="https://www.openstreetmap.org/search?query=<?=urlencode(esc($post->address) . ($post->city ? ' ' . esc($post->city) : ''))?>" rel="external noopener noreferrer nofollow" target="_blank"><?= _('View on Open Street Map') ?></a></p>
                        </dd>
                        <?php endif?>
                    </dl>
                    <?php endif?>
                </aside>
            </div>
        </article>
        
        <?php if ($post->user_id == auth()->user()->id): ?>
        <p class="buttons">
            <a href="<?= route('posts.edit', $post->id)?>" class="button is-link"><?= _('Edit your post') ?></a>
        </p>
        <?php endif?>

        <p>
            <a href="<?= route('posts.index') ?>"><?= _('View all posts') ?></a>
        </p>
    </div>
</section>

<?= $this->endSection() ?>