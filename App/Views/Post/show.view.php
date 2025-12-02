<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Post $post */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= htmlspecialchars($post->getTitle()) ?></h2>
        <a class="btn btn-secondary" href="<?= $link->url('index') ?>">Späť na zoznam</a>
    </div>
    <div class="text-muted mb-3">Vytvorené: <?= htmlspecialchars($post->getCreatedAt()) ?></div>
    <div class="card">
        <div class="card-body">
            <p class="card-text"><?= nl2br(htmlspecialchars($post->getContent() ?? '')) ?></p>
        </div>
    </div>
</div>
<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var array{errors?: string[], old?: array} $data */
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? [];
?>
<div class="container mt-4">
    <h2>Pridať príspevok</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $link->url('create') ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Nadpis</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Obsah</label>
            <textarea class="form-control" id="content" name="content" rows="6" required><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Uložiť</button>
            <a href="<?= $link->url('index') ?>" class="btn btn-secondary">Späť</a>
        </div>
    </form>
</div>
