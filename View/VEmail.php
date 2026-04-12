<?php

class VEmail {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function generateEventCancellationEmail(EEvent $event, string $reasonForDeletion) : string {
        $this->smarty->assign('eventTitle', $event->getTitle());
        $this->smarty->assign('reasonForDeletion', $reasonForDeletion);
        return $this->smarty->fetch('eventCancellationEmail.tpl');
    }
}

?>