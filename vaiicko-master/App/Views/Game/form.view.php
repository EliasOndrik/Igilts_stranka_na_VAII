<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var App\Models\Hry $game */

use App\Configuration;

?>
<div class="container">
    <div class="row">
        <form method="post" action="<?= $link->url('game.save') ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= @$game?->getIDHra() ?>">
            <div class="form-group mb-3">
                <label for="name">Názov hry</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= @$game?->getNazov() ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="author">Autor hry</label>
                <input type="text" class="form-control" id="author" name="author" value="<?= @$game?->getAutor() ?>">
            </div>
            <div class="form-group mb-3">
                <label for="link">Url hry</label>
                <input type="text" class="form-control" id="link" name="link" value="<?= @$game?->getLink() ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="picture">Obrázok hry</label>
                <?php if (@$game?->getObrazok() != null ): ?>
                    <div class="mb-2">
                        <img src="<?= $link->asset(Configuration::UPLOAD_URL . $game->getObrazok()) ?>" alt="Obrázok hry" width="100%">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="picture" name="picture" value="" <?= @$game?->getObrazok()??'required' ?>>
            </div>
            <div class="form-group mb-3">
                <label for="popis" class="form-label">Popis hry</label>
                <textarea class="form-control" id="popis" rows="3" name="popis" required><?= @$game?->getPopis() ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Ulož</button>
        </form>
    </div>
</div>
