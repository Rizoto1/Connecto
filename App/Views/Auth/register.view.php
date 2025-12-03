<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Register form</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$message ?>
                    </div>
                    <form class="form-signin" method="post" action="<?= $link->url("register") ?>" enctype="multipart/form-data">
                        <div class="form-label-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input name="username" type="text" id="username" class="form-control" placeholder="Username"
                                   required autofocus>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input name="email" type="text" id="email" class="form-control" placeholder="Email"
                                   required autofocus>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="avatar" class="form-label">Profilová fotka (voliteľné)</label>
                            <input name="avatar" type="file" id="avatar" class="form-control" accept="image/*">
                        </div>
                        <div class="text-center">
                            <button class="btn-style btn-style-big" type="submit" name="submit">Register
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
