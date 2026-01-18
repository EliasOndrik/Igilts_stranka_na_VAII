<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var App\Models\Hry[] $games */

use App\Configuration;

?>
<div class="container">
    <div class="row mb-4 mt-4">
        <a class="btn btn-primary" href="<?= $link->url('add')?>">Pridať hru</a>
    </div>
    <div class="row">
        <?php foreach ($games as $game): ?>
            <div class="col-lg-3 mb-4">
                <div class="card ">
                    <a href="<?= $link->url('game.game', ['id' => $game->getIDHra()]) ?>" class="text-decoration-none">
                        <img src="<?= $link->asset(Configuration::UPLOAD_URL . $game->getObrazok()) ?>" class="card-img-top" alt="Obrázok hry">
                        <div class="card-body ">
                            <h5 class="card-title"><?= $game->getNazov() ?></h5>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
