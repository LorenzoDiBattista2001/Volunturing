<?php

class VWithdrawApplication {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the control panel for an application of the user's
     * 
     * @param \EApplication $application The application to be managed by the volunteer
     * @param \EEvent $event The event which the application was submitted for
     */
    public function displayApplicationPanel(EApplication $application, EEvent $event) {
        $this->smarty->assign('application', $application);
        $this->smarty->assign('event', $event);
        $this->smarty->display('applicationPanel.tpl');
    }
}

?>