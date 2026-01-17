<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Admini;
use App\Models\Hry;
use App\Models\Komentare;
use App\Models\Pouzivatelia;
use App\Models\ZanreHry;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class SettingController extends BaseController
{
    public function index(Request $request): Response
    {
        $logged = $this->app->getAuth()->getUser();
        $user = Pouzivatelia::getOne($logged->getId());
        $message = null;
        if ($request->hasValue('submit')) {
            if ($request->hasValue('username')) {
                if(Pouzivatelia::getCount("prezivka = ?", [$request->value('username')]) > 0 ){
                    $message = "Prezívka je už obsadená.";
                    return $this->html(compact("message"));
                }

                $newUsername = $request->value('username');
                if (preg_match("/\s/", $newUsername) || strlen($newUsername) < 1) {
                    $message = 'Neplatná prezívka';
                    return $this->html(compact("message"));
                }
                $user->setPrezivka($newUsername);
                $user->save();
                $logged->setUsername($newUsername);
                $logged->setName($newUsername);
            }
            if ($request->hasValue('currentPassword')) {
                $currentPassword = $request->value('currentPassword');
                $newPassword = $request->value('newPassword');
                $confirmPassword = $request->value('confirmPassword');

                if (!password_verify($currentPassword, $user->getHeslo())) {
                    $message = "Súčasné heslo je zle.";
                    return $this->html(compact("message"));
                }

                if (strcmp($newPassword, $confirmPassword) !== 0) {
                    $message = "Nové heslá sa nezhodujú.";
                    return $this->html(compact("message"));
                }
                $user->setHeslo(password_hash($newPassword, Configuration::PASSWORD_ALGO));
                $user->save();
            }

        }
        if ($request->hasValue('imgChange')) {
            if ($request->value("avatar") === ""){
                $message = "Nebol vybraný žiadny súbor.";
                return $this->html(compact("message"));
            }
            if (!is_dir(Configuration::UPLOAD_DIR)) {
                if (!@mkdir(Configuration::UPLOAD_DIR, 0777, true) && !is_dir(Configuration::UPLOAD_DIR)) {
                    throw new HttpException(500, 'Nepodarilo sa vytvoriť adresár pre nahrávanie súborov.',);
                }
            }

            $oldPath = Configuration::UPLOAD_DIR . $user->getObrazok();
            if (is_file($oldPath) && strcmp($user->getObrazok(), "default.png") !== 0) {
                @unlink($oldPath);
            }
            // Generate unique file name and store uploaded file
            $newFile = $request->file('avatar');
            $uniqueName = time() . '-' . $newFile->getName();
            $targetPath = Configuration::UPLOAD_DIR . $uniqueName;

            if (!$newFile->store($targetPath)) {
                throw new HttpException(500, 'Chyba pri ukladaní súboru.');
            }

            $user->setObrazok($uniqueName);
            $user->save();
        }
        if ($request->hasValue('delete')) {
            $this->app->getAuth()->logout();
            $this->deleteAccount($user);

            return $this->redirect($this->url("home.index"));
        }

        return $this->html(compact("message"));
    }
    public function account(Request $request): Response
    {

        if ($request->hasValue('remove')) {
            $remove = $request->value('user');
            if (Admini::isAdmin($remove)) {
                Admini::getOne($remove)->delete();
            }
        }
        if ($request->hasValue('add')) {
            $add = $request->value('user');
            if (Admini::isAdmin($add) === false) {
                $admin = new Admini();
                $admin->setIDAdmin($add);
                $admin->save();
            }

        }
        if ($request->hasValue('delete')) {
            $delete = $request->value('user');
            $this->deleteAccount(Pouzivatelia::getOne($delete));
        }
        $users = Pouzivatelia::getAll();
        return $this->html(compact("users") );
    }

    private function deleteAccount($account){
        $oldPath = Configuration::UPLOAD_DIR . $account->getObrazok();
        if (is_file($oldPath) && strcmp($account->getObrazok(),'default.png') !== 0 ) {
            @unlink($oldPath);
        }
        $admin = Admini::getOne($account->getIDPouzivatel());
        if ($admin !== null) {
            $admin->delete();
        }
        $komentare = Komentare::getAll('ID_pouzivatel = ?', [$account->getIDPouzivatel()]);
        foreach ($komentare as $komentar) {
            $komentar->delete();
        }
        $hry = Hry::getAll('ID_nahravac = ?', [$account->getIDPouzivatel()]);
        foreach ($hry as $hra) {
            $komentarHry = Komentare::getAll("ID_hra = ?", [$hra->getIDHra()]);
            foreach ($komentarHry as $komentarHryItem) {
                $komentarHryItem->delete();
            }
            $zanreHry = ZanreHry::getAll("ID_hra = ?", [$hra->getIDHra()]);
            $zanreHry[0]?->delete();
            $hra->delete();
        }
        $account->delete();
    }
}