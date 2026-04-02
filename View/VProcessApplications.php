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

    public function displayApplicationDetails(EApplication $application) {
        $this->smarty->assign('application', $application);
        $this->smarty->assign('event', $application->getEvent());
        $this->smarty->assign('candidate', $application->getCandidate());
        $this->smarty->display('applicationDetails.tpl');
    }
}

?>