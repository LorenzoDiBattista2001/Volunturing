<?php

class CError {

    // generic error messages, valid for all kinds of users

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

    public static function handleChangePasswordErrors() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('changePasswordError')) {
            $view = new VError();

            $header = 'Errore nel Cambio Password';
            $text = USession::getInstance()->getSessionElement('changePasswordError');

            $view->displayErrorMessage($header, $text, CUser::isAdmin());
        }
    }

    public static function handleRegistrationErrors() : void {
        if(USession::getInstance()->isElementSet('registrationError')) {
            $view = new VError();

            $header = 'Registrazione fallita';
            $text = USession::getInstance()->getSessionElement('registrationError');

            $view->displayErrorMessage($header, $text);
        }
    }

    // error messages for volunteers

    public static function handleCreditCardErrors() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('creditCardError')) {
            $view = new VError();

            $header = 'ERROR: INVALID CARD DATA';
            $text = USession::getInstance()->getSessionElement('creditCardError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function handleDonationAmountError() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('donationError')) {
            $view = new VError();

            $header = 'ERROR: INVALID DONATION AMOUNT';
            $text = USession::getInstance()->getSessionElement('donationError');

            $view->displayErrorMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function handlePaymentError() : void {
        $view = new VError();

        $header = 'Transazione Fallita';
        $text = 'Al momento non siamo in grado di eseguire la transazione. Ti invitiamo a riprovare più tardi';

        $view->displayErrorMessage($header, $text);
    }

    public static function handleApplicationWithdrawalErrors() : void {
        if(CUser::isLogged() && USession::getInstance()->isElementSet('applicationWithdrawalError')) {
            $view = new VError();

            $header = 'Operation Failed';
            $text = USession::getInstance()->getSessionElement('applicationWithdrawalError');

            $view->displayErrorMessage($header, $text);
        }
    }

    // error messages for admins

    public static function handleApplicationProcessingErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('applicationProcessingError')) {
            $view = new VError();

            $header = 'Operation Denied';
            $text = USession::getInstance()->getSessionElement('applicationProcessingError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function handleEventCreationErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('eventCreationError')) {
            $view = new VError();

            $header = 'Event Creation Failed';
            $text = USession::getInstance()->getSessionElement('eventCreationError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function handleEventDeletionErrors() : void {
        if(CUser::isLogged() && CUser::isAdmin() && USession::getInstance()->isElementSet('eventDeletionError')) {
            $view = new VError();

            $header = 'Event Deletion Failed';
            $text = USession::getInstance()->getSessionElement('eventDeletionError');

            $view->displayErrorMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }
}

?>