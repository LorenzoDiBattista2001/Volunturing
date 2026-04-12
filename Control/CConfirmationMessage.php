<?php

class CConfirmationMessage {

    public static function confirmEventCreation() : void {
        $view = new VConfirmationMessage();
        
        $header = 'Nuovo evento creato con successo!';
        $text = 'I dettagli dell\'evento sono ora visibili a tutti gli utenti';

        $view->displayConfirmationMessage($header, $text, isAdmin: true);
    }

    public static function confirmEventDeletion() : void {
        $view = new VConfirmationMessage();

        $header = 'Eliminazione evento completata';
        $text = 'L\'evento è stato eliminato correttamente';

        $view->displayConfirmationMessage($header, $text, isAdmin: true);
    }

    public static function confirmScheduledEventDeletion() : void {
        $view = new VConfirmationMessage();

        $header = 'Eliminazione evento completata';
        $text = 'L\'evento è stato eliminato correttamente. A tutti i volontari interessati è stata recapitata una email di notifica';

        $view->displayConfirmationMessage($header, $text, isAdmin: true);
    }

    public static function confirmApplicationSubmission() : void {
        $view = new VConfirmationMessage();

        $header = 'Candidatura inviata con successo!';
        $text = 'Monitora lo stato della tua candidatura dalla tua area personale';

        $view->displayConfirmationMessage($header, $text);
    }

    public static function confirmApplicationWithdrawal(int $eventId) : void {
        $view = new VConfirmationMessage();
        $event = FPersistentManager::getInstance()->loadEvent($eventId);

        $header = 'Candidatura ritirata';
        $text = 'La tua candidatura per l\'evento ' . $event->getTitle() . ' è stata ritirata';

        $view->displayConfirmationMessage($header, $text);
    }

    public static function confirmDonationReception() : void {
        $view = new VConfirmationMessage();

        $header = 'Transazione Riuscita';
        $text = 'Grazie infinite per la tua generosità!';

        $view->displayConfirmationMessage($header, $text);
    }

    public static function confirmReviewPublishing() : void {
        $view = new VConfirmationMessage();

        $header = 'Recensione pubblicata';
        $text = 'Grazie per aver espresso il tuo parere!';

        $view->displayConfirmationMessage($header, $text);
    }

    public static function confirmPasswordChange() : void {
        $view = new VConfirmationMessage();

        $header = 'Operazione Riuscita';
        $text = 'La tua password è stata aggiornata correttamente';

        $view->displayConfirmationMessage($header, $text, CUser::isAdmin());
    }

    public static function confirmLogout() : void {
        $view = new VConfirmationMessage();

        $header = 'LOGOUT COMPLETATO';
        $text = 'A presto!';

        $view->displayLogoutMessage($header, $text);
    }
}

?>