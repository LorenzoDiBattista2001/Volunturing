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
            }
            try {
                $user = new EVolunteer($firstName, $lastName, $email, $password, $birthDate,
                    $birthPlace, $taxCode, $telephoneNumber, $streetAddress, $houseNumber, isBlocked: false);
                FPersistentManager::getInstance()->storeObject($user);
                USession::getInstance();
                USession::setSessionElement('user', $user->getUserId());
                // display user's home page and welcome message
            } catch (Exception $e) {
                print("Error occurred during registration: " . $e->getMessage());
                // redirect to error page
                exit();
            }
        } else {
            //reload registration form
        }
    }

    public static function startRegistration() : void {

    }

    public static function performLogin() : void {
        if(UServer::getRequestMethod() === 'POST') {
            $email = UHTTPMethods::post('email');
            $password = UHTTPMethods::post('password');

            $user = FPersistentManager::getInstance()->loadUserByEmail($email);

            try {
                if(isset($user) && password_verify($password, $user->getPassword())) {
                    USession::getInstance();
                    USession::setSessionElement('user', $user->getUserId());
                    // display user's home page
                } else {
                    // reload login form
                }
            } catch (Exception $e){
                print("Error occurred during login: " . $e->getMessage());
            }
        } else {
            // reload login form
        }
    }

    public static function authenticate() : void {

    }

    public static function isLogged() : bool {
        return USession::isElementSet('user');
    }

    public static function accessPersonalArea() : void {

    }

    public static function showHome() : void {
        $view = new VUser();
        $view->displayHomePage(self::isLogged());
    }
}
?>