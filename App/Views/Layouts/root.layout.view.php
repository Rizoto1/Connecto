<?php

/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= App\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <div class="row w-100 align-items-center">
            <!-- Left: Logo -->
            <div class="col-4 col-md-3 d-flex justify-content-start align-items-center">
                <a class="navbar-brand" href="<?= $link->url('home.index') ?>" style="width:100px;">
                    <img src="<?= $link->asset('images/connecto_logo.png') ?>" title="<?= App\Configuration::APP_NAME ?>" alt="Framework Logo" style="height:40px; width:100px; object-fit:contain;">
                </a>
            </div>
            <!-- Center: Search bar -->
            <div class="col-4 col-md-6 d-flex justify-content-center">
                <form class="d-none d-sm-flex w-100" role="search" style="max-width:400px;">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
            <!-- Right: Profile or Login -->
            <div class="col-4 col-md-3 d-flex justify-content-end align-items-center">
                <?php if ($user->isLoggedIn()) { ?>
                    <span class="navbar-text me-2 d-none d-md-block">
                        <b><?= $user->getName() ?></b>
                    </span>
                    <a class="nav-link" href="<?= $link->url('auth.logout') ?>">Log out</a>
                <?php } else { ?>
                    <a class="nav-link" href="<?= App\Configuration::LOGIN_URL ?>">Log in</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
