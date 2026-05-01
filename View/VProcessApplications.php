<?php

class VProcessApplications {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the list of scheduled events along with summary data about the applications to be processed
     * 
     * @param array $events The events to be displayed
     */
    public function displayEventsList($events) {
        $this->smarty->assign('events', $events);
        $this->smarty->display('applicationsManagement.tpl');
    }

    /**
     * Displays an event's details and the list of pending applications for that event
     * 
     * @param \EEvent $event The event whose applications are to be listed
     * @param array $applications The pending applications (i.e. the applications waiting to be processed)
     */
    public function displayApplicationsList(EEvent $event, $applications) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('applications', $applications);
        $this->smarty->display('applicationsList.tpl');
    }

    /**
     * Displays the details page for a specific application
     * 
     * @param \EApplication $application The application to be processed by the admin
     */
    public function displayApplicationDetails(EApplication $application) {
        $this->smarty->assign('application', $application);
        $this->smarty->assign('event', $application->getEvent());
        $this->smarty->assign('candidate', $application->getCandidate());
        $this->smarty->display('applicationDetails.tpl');
    }
}

?>