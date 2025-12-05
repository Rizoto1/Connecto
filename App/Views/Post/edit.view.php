<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var array|null $errors */
/** @var \App\Models\Post $post */
?>
<div class="container mt-4">
    <h2>Upraviť príspevok</h2>

    <?php if (!empty($errors)) { ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error) { ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <form method="post" action="<?= $link->url('edit', ['id' => $post->getId()]) ?>" enctype="multipart/form-data" class="mt-3">
        <input type="hidden" name="id" value="<?= (int)$post->getId() ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Názov</label>
            <input type="text" class="form-control" id="title" name="title" required
                   value="<?= htmlspecialchars($post->getTitle() ?? '') ?>" placeholder="Zadajte názov príspevku">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Kontent</label>
            <textarea class="form-control" id="content" name="content" rows="6" required
                      placeholder="Napíšte obsah príspevku"><?= htmlspecialchars($post->getContent() ?? '') ?></textarea>
        </div>

        <?php if ($post->getImage()) { ?>
            <div class="mb-3">
                <label class="form-label d-block">Aktuálny obrázok</label>
                <img src="<?= htmlspecialchars($link->asset($post->getImage())) ?>" alt="current image" style="max-width: 300px; height: auto;" />
            </div>
        <?php } ?>

        <div class="mb-3">
            <label for="image" class="form-label">Nahradiť obrázok</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <div class="form-text">Voliteľné. Nahrajte nový obrázok, ak chcete nahradiť existujúci.</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-style btn-style-big">Uložiť zmeny</button>
            <a href="<?= $link->url('profile.post') ?>" class="btn-style btn-style-big">Späť na moje príspevky</a>
        </div>
    </form>
</div>

