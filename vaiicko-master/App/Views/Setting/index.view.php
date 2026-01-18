<?php
/** @var string|null $message */
/** @var Framework\Support\LinkGenerator $link */
/** @var \Framework\Core\IAuthenticator $auth */

use App\Configuration;
use App\Models\Pouzivatelia;

?>
<div id="profile-settings" class="container">
    <div class="row">
        <div class="col-2">
            <img class="profile" src="<?= $link->asset(Configuration::UPLOAD_URL . Pouzivatelia::getObrazokPath($auth->getUser()->getId())) ?>" alt="Profilový obrázok" width="100%">
            <div class="text-center text-danger mb-3">
                <?= @$message ?>
            </div>
        </div>
        <div class="col-10">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="mb-4">Nastavenia účtu</h1>
                    <!-- Zmena používateľského mena -->
                    <div class="card mb-4">
                        <div class="card-header">Zmena používateľského mena</div>
                        <div class="card-body">
                            <form id="username-form" action="<?= $link->url('index') ?>" method="post" class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nové používateľské meno" value="<?= $auth->getUser()->getUsername() ?>">
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col align-self-start">
                                    <button type="submit" class="btn btn-primary" name="submit">Premenovať</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Zmena hesla -->
                    <div class="card mb-4">
                        <div class="card-header">Zmena hesla</div>
                        <div class="card-body">
                            <form id="password-form" action="<?= $link->url('index') ?>" method="post" class="row g-2 align-items-center">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Aktuálne heslo">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="password" class="form-control" id="password" name="newPassword" placeholder="Nové heslo">
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Potvrďte nové heslo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-warning" name="submit">Zmeniť heslo</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Zmena profilového obrázka -->
                    <div class="card mb-4">
                        <div class="card-header">Zmena profilového obrázka</div>
                        <div class="card-body">
                            <form id="image-form" action="<?= $link->url('index') ?>" method="post" enctype="multipart/form-data" class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <input type="file" accept=".jpg,.gif,.png" class="form-control" id="avatar" name="avatar">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary" name="imgChange" disabled>Zmeniť obrázok</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <form action="<?= $link->url('index') ?>" method="post" enctype="multipart/form-data">
                            <button class="btn btn-danger" type="submit" name="delete">Vymazať účet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
