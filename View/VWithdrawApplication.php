<?php

class VWithdrawApplication {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayApplicationPanel(EApplication $application, EEvent $event) {
        $this->smarty->assign('application', $application);
        $this->smarty->assign('event', $event);
        $this->smarty->display('applicationPanel.tpl');
    }
}

?>