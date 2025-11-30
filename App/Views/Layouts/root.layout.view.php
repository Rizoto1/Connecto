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
            <div class="col-4 col-md-6 d-flex justify-content-center align-items-center">
                <!-- Desktop search bar -->
                <form class="d-none d-sm-flex w-100" role="search" style="max-width:400px;">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                <!-- Mobile search icon -->
                <button class="btn d-sm-none" type="button" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.442 1.398a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                    </svg>
                </button>
            </div>
            <!-- Right: Profile or Login + Sidebar toggle -->
            <div class="col-4 col-md-3 d-flex justify-content-end align-items-center">
                <!-- Sidebar toggle button for mobile -->
                <button class="btn btn-outline-secondary d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                    <span class="navbar-toggler-icon"></span>
                </button>
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
<!-- Mobile search modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="search">
                    <input class="form-control mb-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary w-100" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sidebar for desktop and offcanvas for mobile -->
<div class="d-flex">
    <!-- Desktop sidebar -->
    <div class="d-none d-md-flex flex-column justify-content-between align-items-center bg-light sidebar">
        <div class="mt-3 w-100 d-flex flex-column align-items-center gap-3">
            <button type="button" class="btn-style">Tlačidlo 1</button>
            <button type="button" class="btn-style">Tlačidlo 2</button>
            <button type="button" class="btn-style">Tlačidlo 3</button>
        </div>
        <div class="mb-3 w-100 d-flex flex-column align-items-center gap-3">
            <button type="button" class="btn-style">Tlačidlo 4</button>
            <button type="button" class="btn-style">Tlačidlo 5</button>
        </div>
    </div>
    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between align-items-center">
            <div class="w-100 d-flex flex-column align-items-center gap-3">
                <button type="button" class="btn-style">Tlačidlo 1</button>
                <button type="button" class="btn-style">Tlačidlo 2</button>
                <button type="button" class="btn-style">Tlačidlo 3</button>
            </div>
            <div class="w-100 d-flex flex-column align-items-center gap-3">
                <button type="button" class="btn-style">Tlačidlo 4</button>
                <button type="button" class="btn-style">Tlačidlo 5</button>
            </div>
        </div>
    </div>
    <div class="flex-grow-1">
        <div class="container-fluid mt-3">
            <div class="web-content">
                <?= $contentHTML ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
