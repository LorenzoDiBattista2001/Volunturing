<?php

class CError {

    // generic error messages, valid for all kinds of users

    /**
     * Custom 404 error
     * 
     * This error is displayed whenever the user's request does
     * not match any URLs supported by the web application.
     * 
     * @return void
     */
    public static function handlePageNotFoundError() : void {
        $view = new VError();

        $header = 'Errore 404 Not Found';
        $text = 'La risorsa richiesta non esiste o non è stata trovata';

        if(CUser::isLogged()) {
            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        } else {
            $view->displayErrorMessage($header, $text);
        }
    }

    /**
     * Custom 500 error
     * 
     * This error is displayed the web server is unable to 
     * fulfill the user's request. In actual facts, it is mainly used
     * to cover database connection errors.
     * 
     * @return void
     */
    public static function handleInternalServerError() : void {
        $view = new VError();

        $header = '500 Internal Server Error';

        if(CUser::isLogged()) {
            $text = 'L\'operazione richiesta non è andata a buon fine. Ci scusiamo per il disagio';
            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        } else {
            $text = 'Al momento il Server non è in grado di gestire la richiesta';
            $view->displayErrorMessage($header, $text);
        }
    }

    /**
     * Custom 403 error
     * 
     * This error is displayed whenever the user tries to access
     * a resource which they should not have access to.
     * 
     * @return void
     */
    public static function handleAccessForbiddenError() : void {
        $view = new VError();

        $header = '403 Accesso Negato';
        $text = 'Non si dispone dell\'autorizzazione ad accedere al contenuto richiesto';

        if(CUser::isLogged()) {
            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        } else {
            $view->displayErrorMessage($header, $text);
        }
    }

    /**
     * Handles errors occurring while trying to change password
     * 
     * @return void
     */
    public static function handleChangePasswordErrors() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('changePasswordError')) {
            $view = new VError();

            $header = 'Errore nel Cambio Password';
            $text = USession::getInstance()->getSessionElement('changePasswordError');
            USession::getInstance()->unsetSessionElement('changePasswordError');

            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        }
    }

    /**
     * Handles errors occurring while trying to change email
     * 
     * @return void
     */
    public static function handleChangeEmailErrors() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('changeEmailError')) {
            $view = new VError();

            $header = 'Errore nel Cambio Email';
            $text = USession::getInstance()->getSessionElement('changeEmailError');
            USession::getInstance()->unsetSessionElement('changeEmailError');

            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        }
    }

    /**
     * Handles errors occurring while trying to register as a volunteer
     * 
     * @return void
     */
    public static function handleRegistrationErrors() : void {
        if(USession::getInstance()->isElementSet('registrationError')) {
            $view = new VError();

            $header = 'Registrazione fallita';
            $text = USession::getInstance()->getSessionElement('registrationError');
            USession::getInstance()->unsetSessionElement('registrationError');

            $view->displayErrorMessage($header, $text);
        }
    }

    /**
     * Handles errors occurring while trying to log in
     * 
     * @return void
     */
    public static function handleLoginErrors() : void {
        if(USession::getInstance()->isElementSet('loginError')) {
            $view = new VError();

            $header = 'Login fallito';
            $text = USession::getInstance()->getSessionElement('loginError');
            USession::getInstance()->unsetSessionElement('loginError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Custom 'login required' warning
     * 
     * This error is used to warn the user that they have to log in
     * in order for their request to be processed.
     * 
     * @return void
     */
    public static function handleLoginRequiredError() : void {
        if(!CUser::isLogged()) {
            $view = new VError();
            $view->displayLoginWarning();
        } else {
            header('Location: /errors/403');
        }
    }

    // error messages for volunteers

    /**
     * Handles errors occurring while making a donation
     * 
     * @return void
     */
    public static function handleDonationErrors() : void {
        if(CUser::isLogged() && CUser::isVolunteer() && USession::getInstance()->isElementSet('donationError')) {
            $view = new VError();

            $header = 'Donazione non riuscita';
            $text = USession::getInstance()->getSessionElement('donationError');
            USession::getInstance()->unsetSessionElement('donationError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while withdrawing an application
     * 
     * @return void
     */
    public static function handleApplicationWithdrawalErrors() : void {
        if(CUser::isLogged() && CUser::isVolunteer() && USession::getInstance()->isElementSet('applicationWithdrawalError')) {
            $view = new VError();

            $header = 'Operation Failed';
            $text = USession::getInstance()->getSessionElement('applicationWithdrawalError');
            USession::getInstance()->unsetSessionElement('applicationWithdrawalError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while publishing a review
     * 
     * @return void
     */
    public static function handleReviewPublishingErrors() : void {
        if(CUser::isLogged() && CUser::isVolunteer() && USession::getInstance()->isElementSet('reviewPublishingError')) {
            $view = new VError();

            $header = 'Pubblicazione Recensione Fallita';
            $text = USession::getInstance()->getSessionElement('reviewPublishingError');
            USession::getInstance()->unsetSessionElement('reviewPublishingError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while trying to update one's profile
     * 
     * @return void
     */
    public static function handleProfileUpdateErrors() : void {
        if(CUser::isLogged() && CUser::isVolunteer() && USession::getInstance()->isElementSet('profileUpdateError')) {
            $view = new VError();

            $header = 'Modifica Profilo Non Riuscita';
            $text = USession::getInstance()->getSessionElement('profileUpdateError');
            USession::getInstance()->unsetSessionElement('profileUpdateError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    // error messages for admins

    /**
     * Handles errors occurring while processing a single application
     * 
     * @return void
     */
    public static function handleApplicationProcessingErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('applicationProcessingError')) {
            $view = new VError();

            $header = 'Operation Denied';
            $text = USession::getInstance()->getSessionElement('applicationProcessingError');
            USession::getInstance()->unsetSessionElement('applicationProcessingError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while creating a new event
     * 
     * @return void
     */
    public static function handleEventCreationErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('eventCreationError')) {
            $view = new VError();

            $header = 'Event Creation Failed';
            $text = USession::getInstance()->getSessionElement('eventCreationError');
            USession::getInstance()->unsetSessionElement('eventCreationError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while deleting an event
     * 
     * @return void
     */
    public static function handleEventDeletionErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('eventDeletionError')) {
            $view = new VError();

            $header = 'Event Deletion Failed';
            $text = USession::getInstance()->getSessionElement('eventDeletionError');
            USession::getInstance()->unsetSessionElement('eventDeletionError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while trying to block a user's profile
     * 
     * @return void
     */
    public static function handleUserBlockingErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('userBlockingError')) {
            $view = new VError();

            $header = 'User Blocking Failed';
            $text = USession::getInstance()->getSessionElement('userBlockingError');
            USession::getInstance()->unsetSessionElement('userBlockingError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while trying to unlock a user's profile
     * 
     * @return void
     */
    public static function handleUserUnlockingErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('userUnlockingError')) {
            $view = new VError();

            $header = 'User Unlocking Failed';
            $text = USession::getInstance()->getSessionElement('userUnlockingError');
            USession::getInstance()->unsetSessionElement('userUnlockingError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Handles errors occurring while deleting a review
     * 
     * @return void
     */
    public static function handleReviewDeletionErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('reviewDeletionError')) {
            $view = new VError();

            $header = 'Failed to Delete Review';
            $text = USession::getInstance()->getSessionElement('reviewDeletionError');
            USession::getInstance()->unsetSessionElement('reviewDeletionError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }
}

?>