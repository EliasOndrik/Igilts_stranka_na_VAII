<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Pouzivatelia;
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
                $newUsername = $request->value('username');
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
                    $message = "Current password is incorrect.";
                    return $this->html(compact("message"));
                }

                if (strcmp($newPassword, $confirmPassword) !== 0) {
                    $message = "New passwords do not match.";
                    return $this->html(compact("message"));
                }
                $user->setHeslo(password_hash($newPassword, Configuration::PASSWORD_ALGO));
                $user->save();
            }

        }
        if ($request->hasValue('imgChange')) {
            if (!is_dir(Configuration::UPLOAD_DIR)) {
                if (!@mkdir(Configuration::UPLOAD_DIR, 0777, true) && !is_dir(Configuration::UPLOAD_DIR)) {
                    throw new HttpException(500, 'Nepodarilo sa vytvoriť adresár pre nahrávanie súborov.',);
                }
            }

            $oldPath = Configuration::UPLOAD_DIR . $user->getObrazok();
            if (is_file($oldPath)) {
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
            $oldPath = Configuration::UPLOAD_DIR . $user->getObrazok();
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
            $user->delete();

            return $this->redirect($this->url("home.index"));
        }

        return $this->html(compact("message"));
    }
    public function account(Request $request): Response
    {
        return $this->html();
    }
}