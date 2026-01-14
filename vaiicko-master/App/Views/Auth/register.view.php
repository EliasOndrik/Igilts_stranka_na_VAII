<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-register my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Registrácia</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$message ?>
                    </div>
                    <form id="register" class="form-signin" method="post" action="<?= $link->url("register") ?>">
                        <div class="form-label-group mb-3">
                            <label for="username" class="form-label">Prezívka</label>
                            <input name="username" type="text" id="username" class="form-control" placeholder="Prezívka"
                                   required autofocus>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" id="email" class="form-control"
                                   placeholder="Email" required>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Heslo</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Heslo" required>
                            <div id="password-warnings" class="invalid-feedback">

                            </div>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="confirm_password" class="form-label">Potrvď heslo</label>
                            <input name="confirm_password" type="password" id="confirm_password" class="form-control"
                                   placeholder="Zopakuj heslo" required>
                        </div>
                        <div class="text-center container-fluid">
                            <a class="btn btn-danger" href="<?= $link->url("home.index")?>">Návrat</a>
                            <button id="register-button" class="btn btn-primary" type="submit" name="submit">Registrovať</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
