<?php

class VUser {

    private $smarty;

    public function __construct(bool $isLogged) {
        $this->smarty = VStartSmarty::configuration();
        $this->smarty->assign($isLogged);
    }

    public function displayHomePage() {
        $this->smarty->display('home.tpl');
    }

    public function displayLoginForm() {
        $this->smarty->display('loginForm.tpl');
    }

    public function displayRegistrationForm() {
        $this->smarty->display('registrationForm.tpl');
    }

    public function displayVolunteerPersonalArea() {
        
    }
}

?>