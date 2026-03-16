<?php

class VUser {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayHomePage(bool $isLogged) {
        $this->smarty->assign('isLogged', $isLogged);
        $this->smarty->display('home.tpl');
    }

    public function displayLoginForm() {
        $this->smarty->assign('isLogged', false);
        $this->smarty->display('loginForm.tpl');
    }

    public function displayRegistrationForm() {
        $this->smarty->assign('isLogged', false);
        $this->smarty->display('registrationForm.tpl');
    }
}

?>