<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var Pouzivatelia $users */

use App\Configuration;
use App\Models\Admini;
use App\Models\Pouzivatelia;

?>
<div class="container">
    <div class="row">
        <?php foreach ($users as $user): ?>
        <div class="col-lg-2 mb-4 mx-2">
            <div class="row card text-center">
                <img class="profile" src="<?= $link->asset(Configuration::UPLOAD_URL . $user->getObrazok()) ?>" alt="Profilova fotka" width="100%">
                <p><?= $user->getPrezivka()?></p>
                <?php if (Admini::isAdmin($this->app->getAuth()->getUser()->getId())):?>
                <form method="post" enctype="multipart/form-data" action="<?=$link->url('account') ?>">
                    <input type="hidden" value="<?=$user->getIdPouzivatel()?>" name="user">
                    <?php if (Admini::isAdmin($user->getIdPouzivatel())): ?>
                        <button class="btn btn-danger" type="submit" name="remove">Odstrániť admina</button>
                    <?php else: ?>
                        <button class="btn btn-warning" type="submit" name="add">Pridať admina</button>
                    <?php endif; ?>
                    <button class="btn btn-secondary" type="submit" name="delete">Odstraniť účet</button>
                </form>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>