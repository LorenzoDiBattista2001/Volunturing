<?php

class CManageEvents {

    public static function accessEventManagement() : void {
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
        ?string $candidateRequirements
    ) : void {
        try {
            $event = new EEvent($title, $dateAndTime, $place, $coordinator, $requestedVolunteerNumber,
            $maxVolunteerNumber, $fieldOfAction, $candidateRequirements);
        } catch (Exception $e) {
            print("ERROR: " . $e->getMessage());
            exit();
        }
        
        $done = FPersistentManager::getInstance()->storeObject($event);
        // display confirmation message if $done === true, error message otherwise

    }
}

?>