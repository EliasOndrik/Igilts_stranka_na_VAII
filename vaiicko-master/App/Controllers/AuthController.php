<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Pouzivatelia;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return \Framework\Http\Responses\Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $logged = null;
        $message = null;
        if ($request->hasValue('submit')) {
            if (Pouzivatelia::getCount("prezivka = ?", [$request->post('username')]) == 0) {
                $message = 'Zla prezívka alebo heslo';
                return $this->html(compact("message"));
            }
            $logged = $this->app->getAuth()->login($request->value('username'), $request->value('password'));
            if ($logged) {
                return $this->redirect($this->url("home.index"));
            }
        }

        $message = $logged === false ? 'Zla prezívka alebo heslo' : null;
        return $this->html(compact("message"));
    }

    public function register(Request $request): Response
    {
        if ($request->isAjax()){
            $jsonData = $request->json();
            $warnings = [];
            if(is_object($jsonData) && property_exists($jsonData, 'username')){
                if(Pouzivatelia::getCount("prezivka = ?", [$jsonData->username]) > 0){
                    $warnings[] = ("Prezívku už používa: " . $jsonData->username);
                }
                if (preg_match("/\s/",$jsonData->username) || strlen($jsonData->username) < 1){
                    $warnings[] = 'Neplatná prezívka';
                }
                return $this->json(json_encode($warnings));
            }
            if(is_object($jsonData) && property_exists($jsonData, 'email')){
                if(Pouzivatelia::getCount("email = ?", [$jsonData->email]) > 0){
                    $warnings[] = ("Email sa už používa");
                }
                if (!filter_var($jsonData->email, FILTER_VALIDATE_EMAIL)) {
                    $warnings[] = 'Neplatný email';
                }
                return $this->json(json_encode($warnings));
            }
            if(is_object($jsonData) && property_exists($jsonData, 'password')){

                if (strlen($jsonData->password) < 8) {
                    $warnings[] = "Príliš krátke";
                }
                if (!preg_match("/\d/", $jsonData->password)) {
                    $warnings[] = "Neobsahuje číslo";
                }
                if (!preg_match("/[A-Z]/", $jsonData->password)) {
                    $warnings[] = "Neobsahuje veľké písmeno";
                }
                if (!preg_match("/[a-z]/", $jsonData->password)) {
                    $warnings[] = "Neobsahuje malé písmeno";
                }
                if (!preg_match("/\W/", $jsonData->password)) {
                    $warnings[] = "Neobsahuje špeciálny znak";
                }
                if (preg_match("/\s/", $jsonData->password)) {
                    $warnings[] = "Obsahuje medzeru";
                }
                return $this->json(json_encode($warnings));
            }
        }

        $logged = null;
        if ($request->hasValue('submit')) {
            $registerUser = new Pouzivatelia();
            if (Pouzivatelia::getCount("prezivka = ?", [$request->value('username')]) > 0) {
                $message = 'Prezívka je už používaná';
                return $this->html(compact("message"));
            }
            if (preg_match("/\s/",$request->value('username'))){
                $message = 'Neplatná prezívka';
                return $this->html(compact("message"));
            }
            if (Pouzivatelia::getCount("email = ?", [$request->value('email')]) > 0) {
                $message = 'Email je už registrovaný';
                return $this->html(compact("message"));
            }
            if (!filter_var($request->value('email'), FILTER_VALIDATE_EMAIL)) {
                $message = 'Neplatný email';
                return $this->html(compact("message"));
            }
            if (strcmp($request->value('password'), $request->value('confirm_password')) !== 0) {
                $message = 'Heslá sa nezhodujú';
                return $this->html(compact("message"));
            }
            $registerUser->setPrezivka($request->value('username'));
            $registerUser->setEmail($request->value('email'));
            $registerUser->setHeslo(password_hash($request->value('password'), Configuration::PASSWORD_ALGO));
            $registerUser->save();

            $logged = $this->app->getAuth()->login($request->value('username'), $request->value('password'));
            if ($logged) {
                return $this->redirect($this->url("home.index"));
            }
        }

        $message = $logged === false ? '' : null;
        return $this->html(compact("message"));
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }
}
