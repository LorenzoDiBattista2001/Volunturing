<?php

class CSubmitApplication {

    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        $view = new VSubmitApplication();
        $view->displayEventsList($scheduledEvents);
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        $view = new VSubmitApplication();
        $view->displayEventDetails($event);
    }

    public static function startApplicationProcess(int $userId, int $eventId) : void {
        $view = new VSubmitApplication();
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if (FPersistentManager::getInstance()->existApplication($userId, $eventId)) {
            $view->displayEventDetails($event, alreadyApplied: true);
            exit();
        }
        if($event->isFull()) {
            $view->displayEventDetails($event, eventFull: true);
            exit();
        }
        $view->displayApplicationForm($event);
    }

    public static function createApplication(?string $message, int $userId, int $eventId) : void {
        $application = new EApplication(date('Y-m-d H:i:s'), EApplicationState::WAITING, $message);
        $application->setUserId($userId);
        $application->setEventId($eventId);
        FPersistentManager::getInstance()->storeObject($application);
        $view = new VSubmitApplication();
        $view->displayConfirmationMessage();
    }

}

?>