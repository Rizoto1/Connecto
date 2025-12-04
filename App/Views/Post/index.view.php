<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Post[] $posts */
/** @var \Framework\Auth\AppUser $user */
?>
<h2>Zoznam príspevkov</h2>

<div class="posts-list post-window">
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

                <!-- Right-side comment window -->
                <div class="comment-window" aria-hidden="true">
                    <div class="header">Komentáre</div>
                    <div class="body">
                        <?php
                        // Load related comments for this post using the Model relationship API
                        try {
                            $comments = $post->getAllRelated(\App\Models\Comment::class);
                        } catch (\Exception $e) {
                            $comments = [];
                        }
                        ?>
                        <?php if (!empty($comments)): ?>
                            <ul style="list-style:none; padding:0; margin:0;">
                                <?php foreach ($comments as $comment): ?>
                                    <li style="border-top:1px solid #eee; padding:0.5rem 0;">
                                        <div style="font-size:0.9rem; color:#333;">
                                            <?= nl2br(htmlspecialchars($comment->getContent() ?? '')) ?>
                                        </div>
                                        <div style="font-size:0.8rem; color:#888;">
                                            <?= htmlspecialchars($comment->getCreatedAt() ?? '') ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Zatiaľ žiadne komentáre.</p>
                        <?php endif; ?>
                    </div>
                    <div class="footer">
                        <?php if ($user->isLoggedIn()) { ?>
                            <form action="<?= $link->url('addComment') ?>" method="post" style="display:flex; gap:0.5rem; align-items:center; width:100%;">
                                <input type="hidden" name="postId" value="<?= (int)($post->getId() ?? 0) ?>" />
                                <input type="text" name="content" placeholder="Napíšte komentár..." style="flex:1;" />
                                <button type="submit">Odoslať</button>
                            </form>
                        <?php } else { ?>
                            <div style="font-size:0.9rem; color:#555;">
                                Pre pridanie komentára sa prosím <a href="<?= App\Configuration::LOGIN_URL ?>">prihláste</a>.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Žiadne príspevky zatiaľ neexistujú.</p>
    <?php endif; ?>
</div>
