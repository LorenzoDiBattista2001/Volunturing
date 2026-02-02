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

    public function storeObject(object $obj) : bool {

        $class = get_class($obj);

        if($class === 'EVolunteer' || $class === 'EAdmin') {
            $fclass = 'FUser';
        } else {
            $fclass = 'F' . substr($class, 1);
        }
        
        return $fclass::store($obj);
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