<?php

class VManageEvents {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the list of the association's events for the admin to act upon
     * 
     * @param array $events All of the events stored on the database
     */
    public function displayEventsList($events) {
        $this->smarty->assign('events', $events);
        $this->smarty->display('eventsManagement.tpl');
    }

    /**
     * Displays the form for creating a new event
     */
    public function displayEventForm() {
        $this->smarty->display('eventForm.tpl');
    }

    /**
     * Displays the control panel for a given event
     * 
     * @param \EEvent $event The event to be managed by the admin
     */
    public function displayEventPanel(EEvent $event) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('isScheduled', $event->isScheduled());
        $this->smarty->display('eventPanel.tpl');
    }

    /**
     * Displays the list of participants to a given event
     * 
     * @param \EEvent $event The event whose list of participants is to be displayed
     * @param array $participants The volunteers whose applications to the event have been approved and not withdrawn thereafter
     */
    public function displayVolunteersList(EEvent $event, $participants) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('participants', $participants);
        $this->smarty->display('volunteersList.tpl');
    }
}

?>