<?php

class VConfirmationMessage {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayConfirmationMessage(string $header, string $text, string $link) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('link', $link);
        $this->smarty->display('confirmationMessage.tpl');
    }
}

?>