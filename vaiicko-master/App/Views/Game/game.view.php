<?php
/** @var Framework\Support\LinkGenerator $link */
/** @var App\Models\Hry $game */

use App\Configuration;
use App\Models\Komentare;
use App\Models\Pouzivatelia;


?>
<div class="container mt-4">
    <input id="secret-id" type="hidden" value="<?= @$game?->getIDHra() ?>">
    <div class="row">
        <iframe src="<?=@$game?->getLink() ?>" msallowfullscreen="true" allow="autoplay; fullscreen *; geolocation; microphone; camera; midi; monetization; xr-spatial-tracking; gamepad; gyroscope; accelerometer; xr; cross-origin-isolated; web-share" id="game_drop" allowtransparency="true" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen="true" scrolling="no" frameborder="0"></iframe>
    </div>
    <div class="row mt-4">
        <?php if($this->app->getAuth()->getUser() != null && @$game->getIDNahravac() == $this->app->getAuth()->getUser()->getId()): ?>
        <div class="col mb-3 d-flex justify-content-end">
            <a href="<?= $link->url('edit', ['id' => $game->getIDHra()]) ?>" class="btn btn-primary me-2">Upraviť hru</a>
            <a href="<?= $link->url('delete', ['id' => $game->getIDHra()]) ?>" class="btn btn-danger">Zmazať hru</a>
        </div>
        <?php endif;
        ?>
    </div>
    <div class="row  border border-secondary rounded py-2">
        <div class="col-md-4">
            <img src="<?= $link->asset(Configuration::UPLOAD_URL . @$game?->getObrazok()) ?>" class="img-fluid" alt="Obrázok hry" width="100%">
        </div>
        <div class="col-md-8">
            <h2><?= @$game?->getNazov() ?></h2>
            <p><strong>Autor hry:</strong> <?= @$game?->getAutor() ?></p>
            <p><strong>Žánre: </strong>
            <?php
                $zanre = @$game?->getZanre();
                if ($zanre != null){
                    foreach ($zanre as $zaner){
                        echo htmlspecialchars($zaner->getZaner()) . ", ";
                    }
                }
            ?>
            </p>
            <p><strong>Popis: </strong> <br><?= htmlspecialchars(@$game?->getPopis()) ?></p>
            <p>Túto hru majú radi: <strong id="hodnotenie"><?= @$game?->getHodnotenie()!=0 ? (int)(@$game?->getLikes()/@$game?->getHodnotenie() * 100):'Nan' ?> %</strong> <i id="like" class="btn btn-success bi bi-hand-thumbs-up mx-2"> <?=@$game?->getLikes() ?></i><i id="dislike" class="btn btn-danger bi bi-hand-thumbs-down mx-2"> <?= @$game?->getHodnotenie()-@$game?->getLikes()?></i></p>

        </div>
    </div>
    <div class="row ">
        <h2>Komentáre</h2>
        <div class="row-fluid mb-3">
            <div class="col-12">
                <?php if($this->app->getAuth()->getUser() != null): ?>
                <form method="post" action="<?= $link->url('game.comment', ['id' => $game->getIDHra()]) ?>">
                    <div class="mb-3">
                        <label for="commentText" class="form-label">Pridať komentár</label>
                        <textarea class="form-control" id="commentText" name="text" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Odoslať</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php foreach (array_reverse(Komentare::getCommentsByGame(@$game->getIDHra())) as $comment): ?>
        <?php $uploader = Pouzivatelia::getOne($comment->getIDPouzivatel()); ?>
        <div class="col-12 border rounded mb-3 p-2">
            <div class="row">
                <div class="col-2 ">
                    <img src="<?= $link->asset(Configuration::UPLOAD_URL . $uploader->getObrazok()) ?>" class="img-fluid profile" alt="Avatar používateľa" width="100%">
                </div>
                <div class="col-10">
                    <div class="card">
                        <div>
                            <div class="card-header">
                                <?= htmlspecialchars($uploader->getPrezivka()) ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?= htmlspecialchars($comment->getPopis()) ?></p>
                            <p class="card-text"><small class="text-muted">Pridané dňa: <?= $comment->getDatumPridania() ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
