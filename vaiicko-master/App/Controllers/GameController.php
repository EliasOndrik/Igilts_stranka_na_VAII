<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Komentare;
use App\Models\Zaner;
use App\Models\ZanreHry;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use App\Models\Hry;
use mysql_xdevapi\Exception;

class GameController extends BaseController
{

    public function index(Request $request): Response
    {
        $games = Hry::getGameByUploader($this->app->getAuth()->getUser()->getId());
        return $this->html(compact('games'));
    }
    public function form(Request $request): Response
    {
        if ($request->isAjax()){
            $jsonData = $request->json();
            if(is_object($jsonData) && property_exists($jsonData, 'zaner')){
                if ($jsonData->zaner === ""){
                    return $this->json(json_encode([]));
                }
                $zanre = Zaner::getAll("zaner LIKE ?",[$jsonData->zaner."%"]);

                return $this->json(json_encode($zanre));
            }

            if (is_object($jsonData) && property_exists($jsonData, 'link')){
                if (!preg_match("/^https:\/\/[a-z0-9.-]+\/.*(html|php|js|embed)(\?.*)?$/i",$jsonData->link) || filter_var($jsonData->link, FILTER_VALIDATE_URL) === false) {
                    return $this->json(json_encode(false));
                } else {
                    return $this->json(json_encode(true));
                }
            }
        }
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
        if($request->hasValue('id')){
            $game = Hry::getOne($request->value('id'));
            if(is_null($game)){
                throw new HttpException(404, "Hra neexistuje");
            }
            if ($game->getIDNahravac() != $this->app->getAuth()->getUser()->getId()){
                throw new HttpException(403, "Nemáte oprávnenie na úpravy tejto hry");
            }
            return $this->html(compact('game'));

        }
        return $this->html();
    }
    public function delete(Request $request): Response
    {
        if($request->hasValue('id')){
            $game = Hry::getOne($request->value('id'));
            if(is_null($game)){
                throw new HttpException(404, "Hra neexistuje");
            }
            if ($game->getIDNahravac() != $this->app->getAuth()->getUser()->getId()){
                throw new HttpException(403, "Nemáte oprávnenie na zmazanie tejto hry");
            }
            $komentare = Komentare::getAll('ID_hra = ?', [$game->getIDHra()]);
            foreach ($komentare as $komentar){
                $komentar->delete();
            }
            $stareZanre = ZanreHry::getAll("ID_hra = ?", [$game->getIDHra()]);
            if ($stareZanre != null){
                $stareZanre[0]->delete();
            }
            $oldFileName = $game->getObrazok();
            $oldPath = Configuration::UPLOAD_DIR . $oldFileName;
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
            $game->delete();
        }
        return $this->redirect($this->url("game.index"));
    }
    public function save(Request $request): Response
    {
        $game = null;
        if ($request->hasValue("submit")){
            $link = $request->value("link");
            if (!preg_match("/^https:\/\/[a-z0-9.-]+\/.*(html|php|js|embed)(\?.*)?$/i",$link) || filter_var($link, FILTER_VALIDATE_URL) === false) {
                return $this->redirect($this->url("game.add"));
            }
            if ($request->value("id") > 0){
                $game = Hry::getOne($request->value("id"));
                if(is_null($game)){
                    throw new HttpException(404, "Hra neexistuje");
                }
                if ($game->getIDNahravac() != $this->app->getAuth()->getUser()->getId()){
                    throw new HttpException(403, "Nemáte oprávnenie na úpravu tejto hry");
                }

            }

            else {
                $game = new Hry();
                $game->setDatumPridania(date("Y-m-d H:i:s", time()));
                $game->setIDNahravac($this->app->getAuth()->getUser()->getId());

            }
            $nazov = $request->value("name");
            $autor = $request->value("author");
            $popis = $request->value("popis");
            $zanre = array_unique($request->hasValue("genres")?$request->value("genres"):[],SORT_NUMERIC);


            $game->setNazov($nazov);
            if ($autor !== ""){
                $game->setAutor($autor);
            }
            $game->setPopis($popis);
            $game->setLink($link);
            $game->setLikes(0);
            $game->setHodnotenie(0);

            if (!is_dir(Configuration::UPLOAD_DIR)) {
                if (!@mkdir(Configuration::UPLOAD_DIR, 0777, true) && !is_dir(Configuration::UPLOAD_DIR)) {
                    throw new HttpException(500, 'Nepodarilo sa vytvoriť adresár pre nahrávanie súborov.',);
                }
            }
            $oldFileName = $game->getObrazok();
            $newFile = $request->file('picture');
            if ($newFile->getError() != UPLOAD_ERR_NO_FILE){
                if ($oldFileName != "") {
                    $oldPath = Configuration::UPLOAD_DIR . $oldFileName;
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                $uniqueName = time() . '-' . $newFile->getName();
                $targetPath = Configuration::UPLOAD_DIR . $uniqueName;

                if (!$newFile->store($targetPath)) {
                    throw new HttpException(500, 'Chyba pri ukladaní súboru.');
                }
            }
            else{
                $uniqueName = $oldFileName;
            }
            $game->setObrazok($uniqueName);
            $game->save();
            $game = Hry::getOne($game->getIDHra());
            $stareZanre = ZanreHry::getAll("ID_hra = ?", [$game->getIDHra()]);
            if ($stareZanre != null){
                $stareZanre[0]->delete();
            }
            foreach ($zanre as $zaner){
                $zanreHry = new ZanreHry();
                $zanreHry->setIDHra($game->getIDHra());
                $zanreHry->setIDZaner($zaner);
                $zanreHry->save();
            }

        }
        if ($game === null){
            return $this->redirect($this->url("game.index"));
        }
        return $this->redirect($this->url("game.game",['id'=>$game->getIDHra()]));
    }
    public function comment(Request $request): Response
    {
        $game = Hry::getOne($request->value('id'));
        if(is_null($game)){
            throw new HttpException(404, "Hra neexistuje");
        }
        $logedUser = $this->app->getAuth()->getUser();
        $comment = new Komentare();
        $comment->setIDPouzivatel($logedUser->getId());
        $comment->setIDHra($request->value("id"));
        $comment->setPopis($request->value("text"));
        $comment->setDatumPridania(date("Y-m-d H:i:s", time()));
        $comment->save();
        $id = $game->getIDHra();
        return $this->redirect($this->url('game.game',compact('id')));
    }
}