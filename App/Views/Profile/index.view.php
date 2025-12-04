<?php
/** @var App\Models\User $user */
/** @var string|null $message */
/** @var string|null $success */
/** @var \Framework\Support\LinkGenerator $link */
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Môj profil</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php } ?>
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= nl2br(htmlspecialchars($message)) ?>
                    </div>
                <?php } ?>

                <form method="post" enctype="multipart/form-data">
                    <!-- Username row -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="fw-semibold">Používateľské meno</div>
                                <div class="text-muted">"<?= htmlspecialchars($user->getName() ?? '') ?>"</div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleEdit('username')">Zmeniť</button>
                        </div>
                        <div id="edit-username" class="mt-2" style="display:none;">
                            <label for="username" class="form-label">Nové používateľské meno</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user->getName() ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Email row -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="fw-semibold">E‑mail</div>
                                <div class="text-muted">"<?= htmlspecialchars($user->getEmail() ?? '') ?>"</div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleEdit('email')">Zmeniť</button>
                        </div>
                        <div id="edit-email" class="mt-2" style="display:none;">
                            <label for="email" class="form-label">Nový e‑mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user->getEmail() ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Password row -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <div class="fw-semibold">Heslo</div>
                                <div class="text-muted">"********"</div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleEdit('password')">Zmeniť</button>
                        </div>
                        <div id="edit-password" class="mt-2" style="display:none;">
                            <label for="password" class="form-label">Nové heslo</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nechajte prázdne, ak nechcete meniť">
                            <div class="form-text">Minimálne 8 znakov, aspoň jedno číslo a jeden špeciálny znak.</div>
                        </div>
                    </div>

                    <!-- Avatar row -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <?php $avatar = $user->getAvatar(); ?>
                                <?php if (!empty($avatar)) { ?>
                                    <img src="<?= $link->asset($avatar) ?>" alt="Avatar" style="width:48px; height:48px; border-radius:50%; object-fit:cover;">
                                <?php } else { ?>
                                    <div class="text-muted">Bez fotky</div>
                                <?php } ?>
                                <div>
                                    <div class="fw-semibold">Profilová fotka</div>
                                    <div class="text-muted">"<?= !empty($avatar) ? htmlspecialchars(basename($avatar)) : '—' ?>"</div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleEdit('avatar')">Zmeniť</button>
                        </div>
                        <div id="edit-avatar" class="mt-2" style="display:none;">
                            <label class="form-label" for="avatar">Nahrať novú fotku</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            <div class="form-text">Ak nič nevyberiete, ostane pôvodná fotka.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" value="1" class="btn btn-primary">Uložiť zmeny</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEdit(field) {
    var el = document.getElementById('edit-' + field);
    if (!el) return;
    var isHidden = el.style.display === 'none' || el.style.display === '';
    el.style.display = isHidden ? 'block' : 'none';
    if (isHidden) {
        var input = el.querySelector('input, textarea, select');
        if (input) { input.focus(); }
    }
}
</script>
