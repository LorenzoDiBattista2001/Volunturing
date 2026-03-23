<?php

class CConfirmationMessage {

    private static string $adminLink = 'Torna alla dashboard';
    private static string $volunteerLink = 'Visita la tua area personale';

    public static function confirmEventCreation() : void {
        $view = new VConfirmationMessage(CUser::isLogged());
        
        $header = 'Nuovo evento creato con successo!';
        $text = 'I dettagli dell\'evento sono ora visibili a tutti gli utenti';

        $view->displayConfirmationMessage($header, $text, self::$adminLink);
    }

    public static function confirmEventDeletion() : void {
        $view = new VConfirmationMessage(CUser::isLogged());

        $header = 'Eliminazione evento completata';
        $text = 'L\'evento è stato eliminato correttamente';

        $view->displayConfirmationMessage($header, $text, self::$adminLink);
    }

    public static function confirmApplicationSubmission() : void {
        $view = new VConfirmationMessage(CUser::isLogged());

        $header = 'Candidatura inviata con successo!';
        $text = 'Monitora lo stato della tua candidatura dalla tua area personale';

        $view->displayConfirmationMessage($header, $text, self::$volunteerLink);
    }

    public static function confirmApplicationWithdrawal(int $eventId) : void {
        $view = new VConfirmationMessage(CUser::isLogged());
        $event = FPersistentManager::getInstance()->loadEvent($eventId);

        $header = 'Candidatura ritirata';
        $text = 'La tua candidatura per l\'evento ' . $event->getTitle() . ' è stata ritirata';

        $view->displayConfirmationMessage($header, $text, self::$volunteerLink);
    }

    public static function confirmDonationReception() : void {
        $view = new VConfirmationMessage(CUser::isLogged());

        $header = 'Transazione Riuscita';
        $text = 'Grazie infinite per la tua generosità!';

        $view->displayConfirmationMessage($header, $text, self::$volunteerLink);
    }

    public static function confirmReviewPublishing() : void {
        $view = new VConfirmationMessage(CUser::isLogged());

        $header = 'Recensione pubblicata';
        $text = 'Grazie per aver espresso il tuo parere!';

        $view->displayConfirmationMessage($header, $text, self::$volunteerLink);
    }
}

?>