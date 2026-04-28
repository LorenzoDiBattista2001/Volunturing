<?php

class CConfirmationMessage {

    // generic confirmation messages, valid for all kinds of users

    /**
     * Confirms that the user's password has been changed
     * 
     * @return void
     */
    public static function confirmPasswordChange() : void {
        if(CUser::isLogged()) {
            $view = new VConfirmationMessage();

            $header = 'Operazione Riuscita';
            $text = 'La tua password è stata aggiornata correttamente';

            $view->displayConfirmationMessage($header, $text, CUser::isAdmin());
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user's email has been changed
     * 
     * @return void
     */
    public static function confirmEmailChange() : void {
        if(CUser::isLogged()) {
            $view = new VConfirmationMessage();

            $header = 'Operazione Riuscita';
            $text = 'La tua email è stata aggiornata correttamente';

            $view->displayConfirmationMessage($header, $text, CUser::isAdmin());
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user has successfully been logged out
     * 
     * @return void
     */
    public static function confirmLogout() : void {
        if(!CUser::isLogged()) {
            $view = new VConfirmationMessage();

            $header = 'LOGOUT COMPLETATO';
            $text = 'A presto!';

            $view->displayLogoutMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    // confirmation messages for volunteers

    /**
     * Confirms that the user has successfully submitted an application to an event
     * 
     * @return void
     */
    public static function confirmApplicationSubmission() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VConfirmationMessage();

            $header = 'Candidatura inviata con successo!';
            $text = 'Monitora lo stato della tua candidatura dalla tua area personale';

            $view->displayConfirmationMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user has successfully withdrawn an application of theirs
     * 
     * @return void
     */
    public static function confirmApplicationWithdrawal(int $eventId) : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VConfirmationMessage();
            $event = FPersistentManager::getInstance()->loadEvent($eventId);

            $header = 'Candidatura ritirata';
            $text = 'La tua candidatura per l\'evento ' . $event->getTitle() . ' è stata ritirata';

            $view->displayConfirmationMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user's donation has been received and correctly processed
     * 
     * @return void
     */
    public static function confirmDonationReception() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VConfirmationMessage();

            $header = 'Transazione Riuscita';
            $text = 'Grazie infinite per la tua generosità!';

            $view->displayConfirmationMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user's review has been published
     * 
     * @return void
     */
    public static function confirmReviewPublishing() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VConfirmationMessage();

            $header = 'Recensione pubblicata';
            $text = 'Grazie per aver espresso il tuo parere!';

            $view->displayConfirmationMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the user's profile information has been correctly updated
     * 
     * @return void
     */
    public static function confirmProfileUpdate() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VConfirmationMessage();

            $header = 'Profilo Aggiornato Correttamente';
            $text = 'Le tue informazioni personali sono state correttamente aggiornate';

            $view->displayConfirmationMessage($header, $text);
        } else {
            header('Location: /errors/403');
        }
    }

    // confirmation messages for admins

    /**
     * Confirms that the new event has been created
     * 
     * @return void
     */
    public static function confirmEventCreation() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VConfirmationMessage();
        
            $header = 'Nuovo evento creato con successo!';
            $text = 'I dettagli dell\'evento sono ora visibili a tutti gli utenti';

            $view->displayConfirmationMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the event has been deleted
     * 
     * @return void
     */
    public static function confirmEventDeletion() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VConfirmationMessage();

            $header = 'Eliminazione evento completata';
            $text = 'L\'evento è stato eliminato correttamente';

            $view->displayConfirmationMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
        
    }

    /**
     * Confirms that a scheduled event has been deleted and all volunteers involved have been notified
     * 
     * @return void
     */
    public static function confirmScheduledEventDeletion() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VConfirmationMessage();

            $header = 'Eliminazione evento completata';
            $text = 'L\'evento è stato eliminato correttamente. A tutti i volontari interessati è stata recapitata una email di notifica';

            $view->displayConfirmationMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the profile of a given user has been blocked
     * 
     * @return void
     */
    public static function confirmUserBlocking() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VConfirmationMessage();

            $header = 'Utente Bloccato con Successo';
            $text = 'All\'utente bloccato è stata recapitata una email contenente la motivazione del blocco';

            $view->displayConfirmationMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Confirms that the profile of a given user has been unlocked
     * 
     * @return void
     */
    public static function confirmUserUnlocking() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VConfirmationMessage();

            $header = 'Utente Riabilitato con Successo';
            $text = 'L\'utente è stato riabilitato e ha nuovamente la facoltà di effettuare il login';

            $view->displayConfirmationMessage($header, $text, isAdmin: true);
        } else {
            header('Location: /errors/403');
        }
    }

}

?>