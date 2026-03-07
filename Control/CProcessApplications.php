<?php

class CProcessApplications {

    public static function accessApplicationManagement() : void {
        // check if user is logged in
        // check if user is admin
        // show events list
    }

    public static function inspectEvent(int $eventId) : void {
        $pm = FPersistentManager::getInstance();
        $event = $pm->loadEvent($eventId);
        $applications = $event->getPendingApplications();
        // display 'eventDetailsAndApplicationsList.tpl'
    }

    public static function selectApplication(int $userId, int $eventId) : void {
        $application = FPersistentManager::getInstance()->loadApplication($userId, $eventId);
        // display 'applicationDetails.tpl'
    }

    public static function approveApplication(int $userId, int $eventId) : void {
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

    public static function rejectApplication(int $userId, int $eventId, string $reason) : void {
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
                    throw new Exception('Error occured while trying to update applications');
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