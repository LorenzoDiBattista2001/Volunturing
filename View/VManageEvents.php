<?php

class VManageEvents {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayEventsList($events) {
        $this->smarty->assign('events', $events);
        $this->smarty->display('eventsManagement.tpl');
    }

    public function displayEventForm() {
        $this->smarty->display('eventForm.tpl');
    }

    public function displayEventPanel(EEvent $event) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('isScheduled', $event->isScheduled());
        $this->smarty->display('eventPanel.tpl');
    }

    public function displayVolunteersList(EEvent $event, $participants) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('participants', $participants);
        $this->smarty->display('volunteersList.tpl');
    }
}

?>