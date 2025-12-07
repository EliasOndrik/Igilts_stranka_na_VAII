<?php
/** @var \Framework\Support\LinkGenerator $link */

?>
<div class="container">
    <div class="row">
        <form method="post" action="<?= $link->url('game.save') ?>" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="name">Názov hry</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
            </div>
            <div class="form-group mb-3">
                <label for="author">Autor hry</label>
                <input type="text" class="form-control" id="author" name="author" value="">
            </div>
            <div class="form-group mb-3">
                <label for="link">Url hry</label>
                <input type="text" class="form-control" id="link" name="link" value="" required>
            </div>
            <div class="form-group mb-3">
                <label for="picture">Obrázok hry</label>
                <input type="file" class="form-control" id="picture" name="picture" value="" required>
            </div>
            <div class="form-group mb-3">
                <label for="popis" class="form-label">Popis hry</label>
                <textarea class="form-control" id="popis" rows="3" name="popis" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Ulož</button>
        </form>
    </div>
</div>
