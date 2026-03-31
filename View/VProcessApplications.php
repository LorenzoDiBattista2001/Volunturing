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

    public function displayApplicationsList(EEvent $event, $applications) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('applications', $applications);
        $this->smarty->display('applicationsList.tpl');
    }
}

?>