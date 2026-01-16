<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var App\Models\Hry[] $games */
use App\Configuration;
?>
<div id="search-games" class="container">
    <div class="row">
        <div class="form-group mb-3">
            <label for="zaner-input">Žánre</label>
            <input type="text" class="form-control dropdown-toggle" id="zaner-input" name="" value="" autocomplete="off" placeholder="Akčné, RPG, ..." data-bs-toggle="dropdown">
            <ul id="dropdown-options" class="dropdown-menu">
            </ul>
            <div id="genre-container" class="mt-2">
            </div>
        </div>
    </div>
    <div id="game-selection" class="row">
        <?php foreach ($games as $game): ?>
            <div class="col-lg-3 mb-4">
                <div class="card">
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

