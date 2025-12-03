<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Post[] $posts */
?>
<h2>Zoznam príspevkov</h2>

<div class="posts-list">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <article class="post-item" style="border:1px solid #ddd; padding:1rem; margin-bottom:1rem;">
                <header style="display:flex; justify-content:space-between; align-items:center;">

                    <small style="color:#666;">
                        <?= htmlspecialchars($post->getCreatedAt() ?? '') ?>
                    </small>
                </header>

                <?php if ($post->getImage()): ?>
                    <div class="post-image" style="margin-top:0.5rem;">
                        <img src="<?= htmlspecialchars($link->asset($post->getImage())) ?>" alt="post image" style="max-width:100%; height:auto;" />
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <?= nl2br(htmlspecialchars($post->getContent() ?? '')) ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Žiadne príspevky zatiaľ neexistujú.</p>
    <?php endif; ?>
</div>
