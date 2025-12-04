<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Post[] $posts */
?>
<h2>Zoznam príspevkov</h2>

<div class="posts-list post-style">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <article class="post-item" style="border:1px solid #ddd; padding:1rem; margin-bottom:1rem;">
                <header style="display:flex; justify-content:space-between; align-items:center;">
                    <h4>
                        <?= htmlspecialchars($post->getTitle() ?? '') ?>
                    </h4>
                    <small style="color:#666;">
                        <?= htmlspecialchars($post->getCreatedAt() ?? '') ?>
                    </small>
                </header>

                <?php if ($post->getImage()): ?>
                    <div class="post-image" style="margin-top:0.5rem;">
                        <img src="<?= htmlspecialchars($link->asset($post->getImage())) ?>" alt="post image" style="max-width:100%; height:auto;" />
                    </div>
                    <!-- Toolbar under the image -->
                    <div class="post-toolbar" style="display:flex; gap:0.5rem; align-items:center; margin-top:0.5rem;">
                        <button type="button" class="btn btn-share" >
                            <img src="<?= $link->asset('images/comment_icon.png') ?>" alt="comments" style="width:16px; height:16px;" />
                        </button>
                        <button type="button" class="btn btn-share" >
                            <img src="<?= $link->asset('images/share_icon.png') ?>" alt="share" style="width:16px; height:16px;" />
                        </button>
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
