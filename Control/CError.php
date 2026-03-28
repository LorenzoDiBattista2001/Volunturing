<?php

class CError {

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
}

?>