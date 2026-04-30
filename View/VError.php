<?php

class VError {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays a custom error message
     * 
     * @param string $header A short piece of text summarizing the gist of the error
     * @param string $text The body of the error message, specifying what exactly happened
     * @param bool $isAdmin Specifies whether the user to display the error message to is an admin
     */
    public function displayErrorMessage(string $header, string $text, bool $isAdmin = false) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('isAdmin', $isAdmin);
        $this->smarty->display('errorMessage.tpl');
    }

    /**
     * Displays a warning telling the user that they need to log in before continuing
     */
    public function displayLoginWarning() {
        $this->smarty->display('loginWarning.tpl');
    }
}

?>