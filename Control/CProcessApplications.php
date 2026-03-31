<?php

class CProcessApplications {

    public static function accessApplicationManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $events = FPersistentManager::getInstance()->retrieveScheduledEventsWithApplications();
            $view = new VProcessApplications();
            $view->displayEventsList($events);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function inspectEvent(int $eventId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $pm = FPersistentManager::getInstance();
            $view = new VProcessApplications();

            $event = $pm->loadEvent($eventId);
            $applications = $event->getPendingApplications();
            
            $view->displayApplicationsList($event, $applications);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function selectApplication(int $eventId, int $userId) : void {
        $application = FPersistentManager::getInstance()->loadApplication($userId, $eventId);
        // display 'applicationDetails.tpl'
    }

    public static function approveApplication(int $eventId, int $userId) : void {
        $pm = FPersistentManager::getInstance();

        $application = $pm->loadApplication($userId, $eventId);
        $application->approve();
        $pm->updateApplication($application);

        $event = $pm->loadEvent($eventId);
        if($event->isFull()) {
            self::rejectAllApplications($event);
        } else {
            self::inspectEvent($event->getEventId());
        }
    }

    public static function rejectApplication(int $eventId, int $userId, string $reason) : void {
        $pm = FPersistentManager::getInstance();

        $application = $pm->loadApplication($userId, $eventId);
        $application->reject($reason);
        $pm->updateApplication($application);

        self::inspectEvent($application->getEventId());
    }

    private static function rejectAllApplications(EEvent $event) : void {
        $pm = FPersistentManager::getInstance();
        $db = FConnectionDB::getInstance();

        $pendingApplications = $event->getPendingApplications();
        $db->beginTransaction();
        try {
            foreach($pendingApplications as $application) {
                $application->reject('POSTI ESAURITI');
                if(!$pm->updateApplication($application)) {
                    throw new Exception('Error occurred while trying to update applications');
                }
            }
            $db->commit();
        } catch(Exception $e) {
            $db->rollBack();
            // display error message
        }

        self::inspectEvent($event->getEventId());
    }
}
?>