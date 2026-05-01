<?php

class VSubmitApplication {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the list of the association's scheduled events
     * 
     * @param array $scheduledEvents The events to be displayed
     */
    public function displayEventsList($scheduledEvents) {
        $this->smarty->assign('scheduledEvents', $scheduledEvents);
        $this->smarty->display('scheduledEvents.tpl');
    }

    /**
     * Displays the details page for an event
     * 
     * @param \EEvent $event The event to display the details of
     * @param bool $alreadyApplied Whether the volunteer has already applied for that event
     * @param bool $eventFull Whether the event has reached the maximum number of approved applications
     */
    public function displayEventDetails(EEvent $event, bool $alreadyApplied = false, bool $eventFull = false) {
        $this->smarty->assign('event', $event);
        $this->smarty->assign('alreadyApplied', $alreadyApplied);
        $this->smarty->assign('eventFull', $eventFull);
        $this->smarty->display('eventDetails.tpl');
    }

    /**
     * Displays the form for submitting an application to a given event
     * 
     * @param \EEvent $event The event which the user is submitting an application for
     */
    public function displayApplicationForm(EEvent $event) {
        $this->smarty->assign('title', $event->getTitle());
        $this->smarty->assign('eventId', $event->getEventId());
        $this->smarty->display('applicationForm.tpl');
    }
}

?>