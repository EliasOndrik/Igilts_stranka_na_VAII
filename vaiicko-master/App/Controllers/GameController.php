<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Komentare;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\Hry;

class GameController extends BaseController
{

    public function index(Request $request): Response
    {
        $games = Hry::getGameByUploader($this->app->getAuth()->getUser()->getId());
        return $this->html(compact('games'));
    }
    public function form(Request $request): Response
    {
        return $this->html();
    }
    public function game(Request $request): Response
    {
        if($request->hasValue('id')){
            $game = Hry::getOne($request->value('id'));
            if(is_null($game)){
                throw new HttpException(404, "Hra neexistuje");
            }
            return $this->html(compact('game'));
        }
        return $this->redirect($this->url('home.index'));
    }
    public function add(Request $request): Response
    {
        return $this->html();
    }
    public function edit(Request $request): Response
    {
        return $this->html();
    }
    public function delete(Request $request): Response
    {
        return $this->html();
    }
    public function save(Request $request): Response
    {
        if ($request->hasValue("submit")){
            $nazov = $request->value("name");
            $autor = $request->value("author");
            $popis = $request->value("popis");
            $link = $request->value("link");
            $game = new Hry();
            $game->setNazov($nazov);
            $game->setAutor($autor);
            $game->setPopis($popis);
            $game->setLink($link);
            $game->setDatumPridania(date("Y-m-d H:i:s", time()));
            $game->setHodnotenie(10);
            $game->setIDNahravac($this->app->getAuth()->getUser()->getId());

            if (!is_dir(Configuration::UPLOAD_DIR)) {
                if (!@mkdir(Configuration::UPLOAD_DIR, 0777, true) && !is_dir(Configuration::UPLOAD_DIR)) {
                    throw new HttpException(500, 'Nepodarilo sa vytvoriť adresár pre nahrávanie súborov.',);
                }
            }
            $oldFileName = $game->getObrazok();
            // Remove old file if present
            if ($oldFileName != "") {
                $oldPath = Configuration::UPLOAD_DIR . $oldFileName;
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Generate unique file name and store uploaded file
            $newFile = $request->file('picture');
            $uniqueName = time() . '-' . $newFile->getName();
            $targetPath = Configuration::UPLOAD_DIR . $uniqueName;

            if (!$newFile->store($targetPath)) {
                throw new HttpException(500, 'Chyba pri ukladaní súboru.');
            }

            $game->setObrazok($uniqueName);
            $game->save();
        }
        return $this->redirect($this->url("game.index"));
    }
    public function comment(Request $request): Response
    {
        $logedUser = $this->app->getAuth()->getUser();
            $comment = new Komentare();
            $comment->setIDPouzivatel($logedUser->getId());
            $comment->setIDHra($request->value("id"));
            $comment->setPopis($request->value("text"));
            $comment->setDatumPridania(date("Y-m-d H:i:s", time()));
            $comment->save();
            $game = Hry::getOne($request->value('id'));
            if(is_null($game)){
                throw new HttpException(404, "Hra neexistuje");
            }
            return $this->redirect($this->url('game.game',compact('game')));


    }
}