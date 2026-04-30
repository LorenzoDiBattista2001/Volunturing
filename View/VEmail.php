<?php

class VEmail {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Generates the HTML email body for notifying candidates about a scheduled event's cancellation
     * 
     * @param \EEvent $event The event having been cancelled
     * @param string $reasonForDeletion The reason why the event was cancelled
     * @return string The HTML body of the email
     */
    public function generateEventCancellationEmail(EEvent $event, string $reasonForDeletion) : string {
        $this->smarty->assign('eventTitle', $event->getTitle());
        $this->smarty->assign('reasonForDeletion', $reasonForDeletion);
        return $this->smarty->fetch('eventCancellationEmail.tpl');
    }

    /**
     * Generates the HTML email body for notifying a user of their account having been blocked
     * 
     * @param string $reason The reason why the user's account was blocked
     * @return string The HTML body of the email
     */
    public function generateUserBlockingEmail($reason) : string {
        $this->smarty->assign('reason', $reason);
        return $this->smarty->fetch('userBlockingEmail.tpl');
    }
}

?>