<?php
/** @var Framework\Support\LinkGenerator $link */
?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="row border border-primary">
                <img src="<?= $link->asset('images/logo.jpg') ?>" alt="idk" width="100%">
                <p>uzivatel</p>
            </div>
            <div class="row">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="my-games-tab" data-bs-toggle="pill" data-bs-target="#my-games" type="button" role="tab" aria-controls="my-games" aria-selected="true">My games</button>
                    <button class="nav-link" id="account-tab" data-bs-toggle="pill" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">Account</button>
                </div>
            </div>
        </div>
        <div class="col-10 border border-primary">
            <div class="row">
                <div class="d-flex align-items-start">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="my-games" role="tabpanel" aria-labelledby="my-games-tab">

                        </div>
                        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 d-flex gap-4  flex-column">
            <h1>Nastavenia účtu</h1>

            <form action="" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                <div class="mb-3">
                    <label for="username" class="form-label">Používateľské meno</label>
                    <input type="text" class="form-control" id="username" name="username"  required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nové heslo</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Profilový obrázok</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>
                <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
            </form>

        </div>
    </div>
