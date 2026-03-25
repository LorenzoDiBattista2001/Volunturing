<?php

class VSubmitApplication {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayEventsList($scheduledEvents) {
        $this->smarty->assign('scheduledEvents', $scheduledEvents);
        $this->smarty->display('scheduledEvents.tpl');
    }

    public function displayEventDetails(EEvent $event, bool $alreadyApplied = false, bool $eventFull = false) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('alreadyApplied', $alreadyApplied);
        $this->smarty->assign('eventFull', $eventFull);
        $this->smarty->display('eventDetails.tpl');
    }

    public function displayApplicationForm(EEvent $event) {
        $this->smarty->assign('title', $event->getTitle());
        $this->smarty->assign('eventId', $event->getEventId());
        $this->smarty->display('applicationForm.tpl');
    }
}

?>