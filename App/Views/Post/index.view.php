<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Post[] $posts */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Príspevky</h2>
    </div>

    <?php if (empty($posts)): ?>
        <p>Zatiaľ tu nie sú žiadne príspevky.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($posts as $post): ?>
                    <div class="d-flex w-100 justify-content-between">
                    </div>
                    <form method="post" action="<?= $link->url('posts.delete') ?>" class="mt-2" onsubmit="return confirm('Naozaj zmazať?');">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Zmazať</button>
                    </form>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
