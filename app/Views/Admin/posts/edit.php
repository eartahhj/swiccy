<?= $this->extend('Layouts/base') ?>

<?=$this->section('title')?><?=_('Manage posts')?><?php $this->endSection()?>

<?= $this->section('content')?>

<section class="template-default template-admin">
    <div class="container">
        <div class="box">
            <h1 class="title is-2"><?=_('Edit post')?></h1>

            <dl>
                <dt>
                    <strong><?= _('Title') ?></strong>
                </dt>
                <dd>
                    <h2><?= esc($post->title) ?></h2>
                </dd>
                <dt>
                    <strong><?= _('Text') ?></strong>
                </dt>
                <dd>
                    <p><?= nl2br(esc($post->text)) ?></p>
                </dd>
                <dt>
                    <strong><?= _('Approved') ?></strong>
                </dt>
                <dd><?= ($post->approved ? _('Yes') : _('No')) ?></dd>
                <dt>
                    <strong><?= _('Actions') ?></strong>
                </dt>
                <dd>
                    <?= view('blocks/posts/form-approval', compact('post')) ?>
                    <?= view('blocks/posts/form-delete', compact('post')) ?>
                </dd>
            </dl>
        </div>
    </div>
</section>

<?= $this->endSection() ?>