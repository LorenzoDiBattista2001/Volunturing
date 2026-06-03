<?php

class CUser {

    /**
     * Performs a user's account registration
     * 
     * @return void
     */
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
            
            try {
                if(FPersistentManager::getInstance()->emailExist($email)) {
                    throw new Exception('L\'indirizzo email inserito non è disponibile');
                }
                if($password !== $passwordConfirm) {
                    throw new Exception('Le due password non coincidono');
                }
                $user = new EVolunteer($firstName, $lastName, $email, $password, $birthDate,
                    $birthPlace, $taxCode, $telephoneNumber, $streetAddress, $houseNumber, isBlocked: false);
                if(!FPersistentManager::getInstance()->storeObject($user)) {
                    header('Location: ' . ROOT . '/errors/500');
                    return;
                }
                USession::getInstance()->setSessionElement('user', $user->getUserId());
                USession::getInstance()->setSessionElement('role', 'volunteer');
                header('Location: ' . ROOT . '/account/personal');
            } catch (PDOException $pe) {
                header('Location: ' . ROOT . '/errors/500');
                return;
            } catch (Exception $e) {
                USession::getInstance()->setSessionElement('registrationError', $e->getMessage());
                header('Location: ' . ROOT . '/errors/registration');
                return;
            }
        } else {
            header('Location: ' . ROOT . '/auth/registrationForm');
        }
    }

    /**
     * Displays the form for registering as a volunteer
     * 
     * @return void
     */
    public static function startRegistration() : void {
        if(!self::isLogged()) {
            $view = new VUser();
            $view->displayRegistrationForm();
        } else {
            header('Location: ' . ROOT . '/');
        }
    }

    /**
     * Changes the user's password
     * 
     * @return void
     */
    public static function changePassword() : void {
        if(UServer::getRequestMethod() === 'POST') {
            if(CUser::isLogged()) {
                $user = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
                $currentPassword = UHTTPMethods::post('currentPassword');
                $newPassword = UHTTPMethods::post('newPassword');
                $confirmPassword = UHTTPMethods::post('confirmPassword');
                $pm = FPersistentManager::getInstance();
                try {
                    if(!password_verify($currentPassword, $user->getPassword())) {
                        throw new Exception('La password corrente è errata');
                    }
                    if($newPassword != $confirmPassword) {
                        throw new Exception('Le due password inserite sono diverse');
                    }

                    $user->setPassword($newPassword);
                    if(!$pm->updateUserPassword($user->getUserId(), $user->getPassword())) {
                        header('Location: ' . ROOT . '/errors/500');
                        return;
                    }
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('changePasswordError', $e->getMessage());
                    header('Location: ' . ROOT . '/errors/changePassword');
                    return;
                }
                header('Location: ' . ROOT . '/confirmations/passwordChanged');

            } else {
                header('Location: ' . ROOT . '/errors/403');
            }
        } else {
            header('Location: ' . ROOT . '/account/personal');
        }
    }

    /**
     * Changes the email address associated with the user's account
     * 
     * @return void
     */
    public static function changeEmail() : void {
        if(CUser::isLogged()) {
            if(UServer::getRequestMethod() === 'POST') {
                $user = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
                $email = UHTTPMethods::post('newEmail');
                $password = UHTTPMethods::post('password');

                try {
                    if(!password_verify($password, $user->getPassword())) {
                        throw new Exception('La password inserita non è corretta');
                    }

                    if(FPersistentManager::getInstance()->newEmailExist($email, $user->getUserId())) {
                        throw new Exception('La nuova email inserita appartiene già ad un utente');
                    }

                    $user->setEmail($email);
                    if(!FPersistentManager::getInstance()->updateUserEmail($user->getUserId(), $email)) {
                        header('Location: ' . ROOT . '/errors/500');
                        return;
                    }
                } catch (PDOException $pe) {
                    header('Location: ' . ROOT . '/errors/500');
                    return;
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('changeEmailError', $e->getMessage());
                    header('Location: ' . ROOT . '/errors/changeEmail');
                    return;
                }
                header('Location: ' . ROOT . '/confirmations/emailChanged');
            } else {
                header('Location: ' . ROOT . '/account/personal');
            }
        } else {
            header('Location: ' . ROOT . '/errors/403');
        }
    }

    /**
     * Updates the information associated with the volunteer's account
     * 
     * @return void
     */
    public static function updateProfile() : void {
        if(self::isLogged() && self::isVolunteer()) {
            if(UServer::getRequestMethod() === 'POST') {
                $volunteer = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'), full: false);
                $telephoneNumber = UHTTPMethods::post('telephoneNumber');
                $streetAddress = UHTTPMethods::post('streetAddress');
                $houseNumber = UHTTPMethods::post('houseNumber');
                $description = UHTTPMethods::post('description');
                try {
                    $volunteer->setTelephoneNumber($telephoneNumber);
                    $volunteer->setStreetAddress($streetAddress);
                    $volunteer->setHouseNumber($houseNumber);
                    $volunteer->setDescription($description);
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('profileUpdateError', $e->getMessage());
                    header('Location: ' . ROOT . '/errors/profileUpdate');
                    return;
                }
                if(!FPersistentManager::getInstance()->updateUserProfile($volunteer)) {
                    header('Location: ' . ROOT . '/errors/500');
                    return;
                }
                header('Location: ' . ROOT . '/confirmations/profileUpdated');
            } else {
                header('Location: ' . ROOT . '/account/manage');
            }
        } else {
            header('Location: ' . ROOT . '/errors/403');
        }
    }

    /**
     * Authenticates the user
     * 
     * @return void
     */
    public static function performLogin() : void {
        if(UServer::getRequestMethod() === 'POST') {
            $email = UHTTPMethods::post('email');
            $password = UHTTPMethods::post('password');
            $pm = FPersistentManager::getInstance();

            try {
                if(!$pm->emailExist($email)) {
                    throw new Exception('L\'email inserita non appartiene a nessun utente');
                }
                $user = $pm->loadUserByEmail($email);
                if(password_verify($password, $user->getPassword())) {
                    $role = ($user::class === 'EAdmin') ? 'admin' : 'volunteer';

                    if($role === 'volunteer' && $user->isBlocked()) {
                        throw new Exception('Spiacenti, il tuo profilo risulta bloccato');
                    } 

                    USession::getInstance()->setSessionElement('user', $user->getUserId());
                    USession::getInstance()->setSessionElement('role', $role);
                    header('Location: ' . ROOT . '/account/personal');
                } else {
                    throw new Exception('Password errata');
                }
            } catch (PDOException $pe) {
                header('Location: ' . ROOT . '/errors/500');
                return;
            } catch (Exception $e){
                USession::getInstance()->setSessionElement('loginError', $e->getMessage());
                header('Location: ' . ROOT . '/errors/login');
                return;
            }
        } else {
            header('Location: ' . ROOT . '/auth/loginForm');
        }
    }

    /**
     * Displays the form for logging in
     * 
     * @return void
     */
    public static function authenticate() : void {
        if(!self::isLogged()) {
            $view = new VUser();
            $view->displayLoginForm();
        } else {
            header('Location: ' . ROOT . '/account/personal');
        }
    }

    /**
     * Destroys the user's current session
     * 
     * @return void
     */
    public static function performLogout() : void {
        if(self::isLogged()) {
            USession::getInstance()->unsetSessionVariables();
            USession::getInstance()->destroySession();

            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            header('Location: ' . ROOT . '/confirmations/logout');
        } else {
            header('Location: ' . ROOT . '/');
        }
    }

    /**
     * Checks whether a user is logged in
     * 
     * @return bool
     */
    public static function isLogged() : bool {
        return USession::getInstance()->isElementSet('user');
    }

    /**
     * Checks whether a user is an admin
     * 
     * @return bool
     */
    public static function isAdmin() : bool {
        return (USession::getInstance()->getSessionElement('role') === 'admin');
    }

    /**
     * Checks whether a user is a volunteer
     * 
     * @return bool
     */
    public static function isVolunteer() : bool {
        return (USession::getInstance()->getSessionElement('role') === 'volunteer');
    }

    /**
     * Displays a volunteer's personal area or an admin's dashboard
     * 
     * @return void
     */
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
            header('Location: ' . ROOT . '/auth/loginForm');
        }
    }

    /**
     * Displays a volunteer's account management area
     * 
     * @return void
     */
    public static function manageAccount() : void {
        if(self::isLogged() && self::isVolunteer()) {
            $view = new VUser();
            $volunteer = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
            $view->displayVolunteerAccountManagement($volunteer);
        } else {
            header('Location: ' . ROOT . '/errors/403');
        }
    }

    /**
     * Displays the web application's general home page
     * 
     * @return void
     */
    public static function showHome() : void {
        $view = new VUser();
        $view->displayHomePage();
    }
}

?>