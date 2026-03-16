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
}

?>