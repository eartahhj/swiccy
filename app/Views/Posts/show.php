<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?= esc($post->title) ?><?php $this->endSection()?>

<?= $this->section('content')?>
<section class="template-default template-post">
    <div class="container">
        <?php if (!$post->approved and $post->user_id == auth()->user()->id): ?>
            <div class="message is-warning">
                <div class="message-header"><?= _('Warning') ?></div>
                <div class="message-body"><?= _('This post has not been approved yet, and is visible only to you.') ?></div>
            </div>
        <?php endif?>

        <article>
            <h1 class="title is-3"><?= esc($post->title) ?></h1>
            <p class="date mb-5"><?= sprintf(_('Posted at: %s'), formatDate($post->created_at)) ?></p>
            
            <div class="grid grid-7-3">
                <article id="post-details" class="grid-col">
                    <h2 class="title is-5"><?= _('Post details') ?></h2>
                    <div id="post-quantity">
                        <span><?= sprintf(_('Quantity I am giving: %s'), intval($post->quantity_give)) ?></span><span><?= sprintf(_('Quantity I want to receive: %s'), intval($post->quantity_receive)) ?></span>
                    </div>
                    <p><?= nl2br(esc($post->text)) ?></p>
                    <?php if ($images):?>
                        <div id="post-images">
                            <h2 class="title is-5"><?= _('Images for this post') ?></h2>
                            <ul>
                                <?php foreach ($images as $image):?>
                                    <?php $i = 1 ?>
                                <li>
                                    <figure>
                                        <a href="/uploads/<?= esc($image->filename) ?>" rel="noopener" target="_blank">
                                            <img src="<?= '/uploads/' . esc($image->filename) ?>" alt="<?= esc($image->alternate_text) ?>" width="<?= intval($image->width) ?>" height="<?= intval($image->height) ?>">
                                            <span class="sr-only"><?= sprintf(_('View image number %s of this post in a new tab'), $i) ?></span>
                                        </a>
                                        <?php if ($image->alternate_text):?>
                                        <figcaption><?= esc($image->alternate_text) ?></figcaption>
                                        <?php endif?>
                                    </figure>
                                </li>
                                <?php $i++ ?>
                                <?php endforeach?>
                            </ul>
                        </div>
                    <?php endif?>
                </article>
                <aside class="grid-col">
                    <h2 class="title is-5"><?= _('Contact information') ?></h2>
                    <a href="<?= route('users.show', $author->id) ?>">
                        <figure>
                            <img src="<?= esc($author->avatar()) ?>" alt="" width="100" height="100">
                        </figure>
                        <?= esc($author->username) ?>
                    </a>
                    <dl class="mt-5">
                        <dt><?= _('Email') ?></dt>
                        <dd>
                            <?php if (auth()->user() and (auth()->user()->active or auth()->user()->inGroup('admin', 'superadmin'))):?>
                                <?= esc($post->email) ?>
                            <?php else:?>
                                <?= substr(esc($post->email), 0, 1) ?>********<br />(<?= sprintf(_('to view the full email address please %s'), '<a href="' . route('register') . '">' . _('register') . '</a>') ?>)
                            <?php endif?>
                        </dd>
                        <?php if ($post->phone_number):?>
                        <dt><?= _('Phone number') ?></dt>
                        <dd>
                            <?php if (auth()->user() and (auth()->user()->active or auth()->user()->inGroup('admin', 'superadmin'))):?>
                            <a href="tel:<?= esc($post->phone_number) ?>"><?= esc($post->phone_number) ?></a>
                            <?php else:?>
                                <?= substr(esc($post->phone_number), 0, 1) ?>********<br />(<?= sprintf(_('to view the full phone number please %s'), '<a href="' . route('register') . '">' . _('register') . '</a>') ?>)
                            <?php endif?>
                        </dd>
                        <?php endif?>
                    </dl>

                    <?php if ($post->city or $post->address): ?>
                    <h2 class="title is-5"><?= _('Location') ?></h2>
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
        
        <?php if (auth()->user() and $post->user_id == auth()->user()->id): ?>
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