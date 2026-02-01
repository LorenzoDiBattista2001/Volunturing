<?php

class FPersistentManager {

    private static $instance;

    private function __construct() {

    }

    public static function getInstance() : FPersistentManager {
        if(!isset(self::$instance)) {
            self::$instance = new FPersistentManager();
        }
        return self::$instance;
    }

    public function loadEventById(int $eventId) : EEvent {
        $event = FEvent::load($eventId);
        $event->setApplications($this->retrieveApplicationsByEvent($event));
        return $event;
    }

    public function retrieveApplicationsByEvent(EEvent $event) {

        $applications = FApplication::loadByEvent($event->getEventId());
        
        foreach($applications as $application) {
            $application->setEvent($event);
            $application->setCandidate(FUser::loadById($application->getUserId()));
        }

        return $applications;
    }

}

?>