<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\User $user */
/** @var \App\Models\Post[] $posts */
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Moje príspevky</h5>
                <a href="<?= $link->url('index') ?>" class="btn btn-outline-secondary btn-sm">Späť na profil</a>
            </div>
            <div class="card-body">
                <?php if (!empty($posts)) { ?>
                    <div class="posts-list post-window">
                        <?php foreach ($posts as $post) { ?>
                            <article class="post-item mb-3" style="border:1px solid #ddd; padding:1rem;">
                                <header class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0"><?= htmlspecialchars($post->getTitle() ?? '') ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($post->getCreatedAt() ?? '') ?></small>
                                </header>
                                <?php if ($post->getImage()) { ?>
                                    <div class="post-image mb-2">
                                        <img src="<?= htmlspecialchars($link->asset($post->getImage())) ?>" alt="post image" style="max-width:100%; height:auto;" />
                                    </div>
                                <?php } ?>
                                <div class="post-content">
                                    <?= nl2br(htmlspecialchars($post->getContent() ?? '')) ?>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p class="mb-0">Zatiaľ nemáte žiadne príspevky.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
