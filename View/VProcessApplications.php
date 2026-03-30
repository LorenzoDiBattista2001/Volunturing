<?php

class VProcessApplications {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayEventsList($events) {
        $this->smarty->assign('events', $events);
        $this->smarty->display('applicationsManagement.tpl');
    }
}

?>