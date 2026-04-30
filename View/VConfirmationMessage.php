<?php

class VConfirmationMessage {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays a custom confirmation message
     * 
     * @param string $header A short piece of text summarizing the action being confirmed
     * @param string $text The body of the confirmation message
     * @param bool $isAdmin Specifies whether the user to display the confirmation message to is an admin
     */
    public function displayConfirmationMessage(string $header, string $text, bool $isAdmin = false) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->assign('isAdmin', $isAdmin);
        $this->smarty->display('confirmationMessage.tpl');
    }

    /**
     * Displays the logout message
     * 
     * @param string $header A short piece of text confirming the logout
     * @param string $text A simple goodbye message
     */
    public function displayLogoutMessage(string $header, string $text) {
        $this->smarty->assign('header', $header);
        $this->smarty->assign('text', $text);
        $this->smarty->display('logoutMessage.tpl');
    }
}

?>