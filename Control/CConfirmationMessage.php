<?php

class CConfirmationMessage {

    private static string $adminLink = 'Torna alla dashboard';

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
}

?>