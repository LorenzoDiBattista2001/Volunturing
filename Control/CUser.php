<?php

class CUser {

    public static function register() : void {
        if(UServer::getRequestMethod() === 'POST') {
            $firstName = UHTTPMethods::post('firstName');
            $lastName = UHTTPMethods::post('lastName');
            $birthDate = UHTTPMethods::post('birthDate');
            $birthPlace = UHTTPMethods::post('birthPlace');
            $telephoneNumber = UHTTPMethods::post('telephoneNumber');
            $taxCode = UHTTPMethods::post('taxCode');
            $streetAddress = UHTTPMethods::post('streetAddress');
            $houseNumber = UHTTPMethods::post('houseNumber');
            $email = UHTTPMethods::post('email');
            $password = UHTTPMethods::post('password');
            $passwordConfirm = UHTTPMethods::post('passwordConfirm');
            if($password !== $passwordConfirm) {
                // reload registration form
                header('Location: /auth/registrationForm');
            }
            try {
                $user = new EVolunteer($firstName, $lastName, $email, $password, $birthDate,
                    $birthPlace, $taxCode, $telephoneNumber, $streetAddress, $houseNumber, isBlocked: false);
                FPersistentManager::getInstance()->storeObject($user);
                USession::getInstance()->setSessionElement('user', $user->getUserId());
                // display user's home page and welcome message
                header('Location: /account/personal');
            } catch (Exception $e) {
                print("Error occurred during registration: " . $e->getMessage());
                // redirect to error page
                exit();
            }
        } else {
            //reload registration form
            header('Location: /auth/registrationForm');
        }
    }

    public static function startRegistration() : void {
        if(!self::isLogged()) {
            $view = new VUser(self::isLogged());
            $view->displayRegistrationForm();
        } else {
            header('Location: /');
        }
    }

    public static function performLogin() : void {
        if(UServer::getRequestMethod() === 'POST') {
            $email = UHTTPMethods::post('email');
            $password = UHTTPMethods::post('password');

            $user = FPersistentManager::getInstance()->loadUserByEmail($email);

            try {
                if(isset($user) && password_verify($password, $user->getPassword())) {
                    USession::getInstance()->setSessionElement('user', $user->getUserId());
                    // display user's home page
                    header('Location: /account/personal');
                } else {
                    // reload login form
                    header('Location: /auth/loginForm');
                }
            } catch (Exception $e){
                print("Error occurred during login: " . $e->getMessage());
            }
        } else {
            // reload login form
            header('Location: /auth/loginForm');
        }
    }

    public static function authenticate() : void {
        if(!self::isLogged()) {
            $view = new VUser();
            $view->displayLoginForm();
        } else {
            header('Location: /account/personal');
        }
    }

    public static function performLogout() : void {
        if(self::isLogged()) {
            USession::getInstance()->unsetSessionVariables();
            USession::getInstance()->destroySession();

            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            // display confirmation message
        } else {
            header('Location: /');
        }
    }

    public static function isLogged() : bool {
        return USession::getInstance()->isElementSet('user');
    }

    public static function isAdmin() : bool {
        $userId = USession::getInstance()->getSessionElement('user');
        return FPersistentManager::getInstance()->isUserAdmin($userId);
    }

    public static function accessPersonalArea() : void {
        if(self::isLogged()) {
            if(self::isAdmin()) {
                // display admin's personal area
            } else {
                // display volunteer's personal area
            }
        } else {
            header('Location: /auth/loginForm');
        }
    }

    public static function showHome() : void {
        $view = new VUser(self::isLogged());
        $view->displayHomePage();
    }
}

?>