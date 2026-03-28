<?php

class VError {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayErrorMessage(string $header, string $text, bool $isAdmin = false) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('isAdmin', $isAdmin);
        $this->smarty->display('errorMessage.tpl');
    }
}

?>