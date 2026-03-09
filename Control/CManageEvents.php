<?php

class CManageEvents {

    public static function accessEventManagement() : void {
        // check if user is logged in
        // check if user id admin
        $events = FPersistentManager::getInstance()->retrieveAllEvents();
        // show events list
    }

    public static function addEvent() : void {
        // show add event form
    }

    public static function createEvent(
        string $title,
        string $dateAndTime,
        string $place,
        string $coordinator,
        int $requestedVolunteerNumber,
        int $maxVolunteerNumber,
        string $fieldOfAction,
        ?string $candidateRequirements,
        string $description
    ) : void {
        try {
            $event = new EEvent($title, $dateAndTime, $place, $coordinator, $requestedVolunteerNumber,
            $maxVolunteerNumber, $fieldOfAction, $candidateRequirements, $description);
        } catch (Exception $e) {
            print("ERROR: " . $e->getMessage());
            exit();
        }
        
        $done = FPersistentManager::getInstance()->storeObject($event);
        // display confirmation message if $done === true, error message otherwise
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        // display event details along with management options
    }

    public static function deleteEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if($event->isScheduled()) {
            // display form for entering reason for deletion
        } else {
            // display confirmation request
        }
    }

    public static function performDeletion(int $eventId, ?string $reasonForDeletion = null) {
        $pm = FPersistentManager::getInstance();
        if(!isset($reasonForDeletion)) {
            $pm->deleteObject($eventId, EEvent::class);
            // display confirmation message
        } else {
            // create notifications for all candidates involved
            $pm->deleteObject($eventId, EEvent::class);
            // display confirmation message
        }
    }
}

?>