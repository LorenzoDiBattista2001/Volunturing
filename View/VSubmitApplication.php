<?php

class VSubmitApplication {

    private $smarty;

    public function __construct(bool $isLogged) {
        $this->smarty = VStartSmarty::configuration();
        $this->smarty->assign($isLogged);
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
        $this->smarty->display('applicationForm.tpl');
    }

    public function displayConfirmationMessage() {
        $this->smarty->display('confirmationMessage.tpl');
    }

}

?>