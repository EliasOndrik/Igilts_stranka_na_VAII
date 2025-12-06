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
                    <h5 class="card-title text-center">Registration</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$message ?>
                    </div>
                    <form class="form-signin" method="post" action="<?= $link->url("register") ?>">
                        <div class="form-label-group mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input name="username" type="text" id="username" class="form-control" placeholder="Username"
                                   required autofocus>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" id="email" class="form-control"
                                   placeholder="Email" required>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" id="password" class="form-control"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-label-group mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input name="confirm_password" type="password" id="confirm_password" class="form-control"
                                   placeholder="Confirm Password" required>
                        </div>
                        <div class="text-center contaner-fluid">
                            <a class="btn btn-danger" href="<?= $link->url("home.index")?>">Return</a>
                            <button class="btn btn-primary" type="submit" name="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
