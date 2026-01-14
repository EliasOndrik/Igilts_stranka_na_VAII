<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var App\Models\Hry $game */

use App\Configuration;

?>
<div class="container">
    <div class="row p-0">
        <form method="post" action="<?= $link->url('game.save') ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= @$game?->getIDHra() ?>">
            <div class="form-group mb-3">
                <label for="name">Názov hry</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= @$game?->getNazov() ?>" placeholder="Názov hry" required>
            </div>
            <div class="form-group mb-3">
                <label for="author">Autor hry</label>
                <input type="text" class="form-control" id="author" name="author" value="<?= @$game?->getAutor() ?>" placeholder="Názov autora">
            </div>
            <div class="form-group mb-3">
                <label for="link">Url hry</label>
                <input type="text" class="form-control" id="link" name="link" value="<?= @$game?->getLink() ?>" placeholder="Url hry" required>
            </div>
            <div class="form-group mb-3">
                <label for="picture">Obrázok hry</label>
                <?php if (@$game?->getObrazok() != null ): ?>
                    <div class="mb-2">
                        <img src="<?= $link->asset(Configuration::UPLOAD_URL . $game->getObrazok()) ?>" alt="Obrázok hry" width="100%">
                    </div>
                <?php endif; ?>
                <input type="file" accept=".jpg,.gif,.png" class="form-control" id="picture" name="picture" value="" <?= @$game?->getObrazok()??'required' ?>>
            </div>
            <div class="form-group mb-3">
                <label for="zaner-input">Žánre</label>
                <input type="text" class="form-control dropdown-toggle" id="zaner-input" name="" value="" autocomplete="off" placeholder="Akčné, RPG, ..." data-bs-toggle="dropdown">
                <ul id="dropdown-options" class="dropdown-menu">
                </ul>
                <div id="genre-container" class="mt-2">
                    <?php
                    $zanre = @$game?->getZanre();
                    if ($zanre !== null) {
                        foreach ($zanre as $zaner) {
                            echo '<span class="btn bg-secondary m-1" onclick="document.gameChanges.removeZaner(this)">' . $zaner->getZaner() . '<input type="hidden" name="genres[]" value="'.$zaner->getIDZaner().'"/></span>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="popis" class="form-label">Popis hry</label>
                <textarea class="form-control" id="popis" rows="3" name="popis" placeholder="Popis hry" required><?= @$game?->getPopis() ?></textarea>
            </div>
            <div class="text-center mb-3">
                <button id="submit-game" type="submit" class="btn btn-primary justify-content-center" name="submit">Ulož</button>
            </div>
        </form>
    </div>
</div>

