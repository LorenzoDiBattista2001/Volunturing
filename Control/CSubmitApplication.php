<?php

class CSubmitApplication {

    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        // show events list
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        // show event details
    }

    public static function startApplicationProcess(int $userId, int $eventId) : void {
        if (FPersistentManager::getInstance()->existApplication($userId, $eventId)) {
            // show alert: user has already applied
        }
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if($event->isFull()) {
            // show alert: event is full
        }
        // show application form
    }

    public static function createApplication(?string $message, int $userId, int $eventId) : void {
        $application = new EApplication(date('Y-m-d H:i:s'), EApplicationState::WAITING, $message);
        $application->setUserId($userId);
        $application->setEventId($eventId);
        FPersistentManager::getInstance()->storeObject($application);
        // show confirmation message
    }


}

?>