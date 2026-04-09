<?php

class VConfirmationMessage {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayConfirmationMessage(string $header, string $text, bool $isAdmin = false) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('isAdmin', $isAdmin);
        $this->smarty->display('confirmationMessage.tpl');
    }

    public function displayLogoutMessage(string $header, string $text) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->display('logoutMessage.tpl');
    }
}

?>