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
                                <div class="post-content mb-2">
                                    <?= nl2br(htmlspecialchars($post->getContent() ?? '')) ?>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?= $link->url('post.edit', ['id' => $post->getId()]) ?>" class="btn btn-sm btn-outline-primary">Upraviť</a>
                                    <form method="post" action="<?= $link->url('post.delete') ?>" onsubmit="return confirm('Naozaj chcete vymazať tento príspevok?');">
                                        <input type="hidden" name="id" value="<?= (int)$post->getId() ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Vymazať</button>
                                    </form>
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
