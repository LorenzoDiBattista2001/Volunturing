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
            if(FPersistentManager::getInstance()->emailExist($email)) {
                USession::getInstance()->setSessionElement('registrationError', 'L\'indirizzo email inserito non è disponibile');
                header('Location: /errors/registration');
                return;
            }
            if($password !== $passwordConfirm) {
                USession::getInstance()->setSessionElement('registrationError', 'Le due password non coincidono');
                header('Location: /errors/registration');
                return;
            }
            try {
                $user = new EVolunteer($firstName, $lastName, $email, $password, $birthDate,
                    $birthPlace, $taxCode, $telephoneNumber, $streetAddress, $houseNumber, isBlocked: false);
                if(!FPersistentManager::getInstance()->storeObject($user)) {
                    header('Location: /errors/500');
                    return;
                }
                USession::getInstance()->setSessionElement('user', $user->getUserId());
                header('Location: /account/personal');
            } catch (Exception $e) {
                USession::getInstance()->setSessionElement('registrationError', $e->getMessage());
                header('Location: /errors/registration');
                return;
            }
        } else {
            //reload registration form
            header('Location: /auth/registrationForm');
        }
    }

    public static function startRegistration() : void {
        if(!self::isLogged()) {
            $view = new VUser();
            $view->displayRegistrationForm();
        } else {
            header('Location: /');
        }
    }

    public static function changePassword() : void {
        if(UServer::getRequestMethod() === 'POST') {
            if(CUser::isLogged()) {
                $user = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
                $currentPassword = UHTTPMethods::post('currentPassword');
                $newPassword = UHTTPMethods::post('newPassword');
                $confirmPassword = UHTTPMethods::post('confirmPassword');

                if(!password_verify($currentPassword, $user->getPassword())) {
                    USession::getInstance()->setSessionElement('changePasswordError', 'La password corrente è errata');
                    header('Location: /errors/changePassword');
                    return;
                }
                if($newPassword != $confirmPassword) {
                    USession::getInstance()->setSessionElement('changePasswordError', 'Le due password inserite sono diverse');
                    header('Location: /errors/changePassword');
                    return;
                }

                $user->setPassword($newPassword);
                if(!FPersistentManager::getInstance()->updateUserPassword($user->getUserId(), $user->getPassword())) {
                    header('Location: /errors/500');
                    return;
                }
                header('Location: /confirmations/passwordChanged');

            } else {
                header('Location: /errors/403');
            }
        } else {
            header('Location: /account/changePassword');
        }
    }

    public static function performLogin() : void {
        if(UServer::getRequestMethod() === 'POST') {
            $email = UHTTPMethods::post('email');
            $password = UHTTPMethods::post('password');
            $pm = FPersistentManager::getInstance();

            try {
                if(!$pm->emailExist($email)) {
                    throw new Exception('L\'email inserita non appartiene a nessun utente');
                }
                $user = FPersistentManager::getInstance()->loadUserByEmail($email);
                if(password_verify($password, $user->getPassword())) {
                    $role = ($user::class === 'EAdmin') ? 'admin' : 'volunteer';

                    if($role === 'volunteer' && $user->isBlocked()) {
                        throw new Exception('Spiacenti, il tuo profilo risulta bloccato');
                    } 

                    USession::getInstance()->setSessionElement('user', $user->getUserId());
                    USession::getInstance()->setSessionElement('role', $role);
                    header('Location: /account/personal');
                } else {
                    throw new Exception('Password errata');
                }
            } catch (Exception $e){
                USession::getInstance()->setSessionElement('loginError', $e->getMessage());
                header('Location: /errors/login');
                return;
            }
        } else {
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
            header('Location: /confirmations/logout');
        } else {
            header('Location: /');
        }
    }

    public static function isLogged() : bool {
        return USession::getInstance()->isElementSet('user');
    }

    public static function isAdmin() : bool {
        return (USession::getInstance()->getSessionElement('role') === 'admin');
    }

    public static function accessPersonalArea() : void {
        if(self::isLogged()) {
            $user = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
            $view = new VUser();
            if($user::class === 'EAdmin') {
                $dashboardData = FPersistentManager::getInstance()->loadDashboardData();
                $view->displayAdminDashboard($user, $dashboardData);
            } else {
                $view->displayVolunteerPersonalArea($user);
            }
        } else {
            header('Location: /auth/loginForm');
        }
    }

    public static function showHome() : void {
        $view = new VUser();
        $view->displayHomePage();
    }
}

?>