<?php

class VConfirmationMessage {

    private $smarty;

    public function __construct(bool $isLogged) {
        $this->smarty = VStartSmarty::configuration();
        $this->smarty->assign('isLogged', $isLogged);
    }

    public function displayConfirmationMessage(string $header, string $text, string $link) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('link', $link);
        $this->smarty->display('confirmationMessage.tpl');
    }
}

?>