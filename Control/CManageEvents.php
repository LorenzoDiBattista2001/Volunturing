<?php

class CManageEvents {

    public static function accessEventManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $events = FPersistentManager::getInstance()->retrieveAllEvents();
            $view = new VManageEvents();
            $view->displayEventsList($events);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function addEvent() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VManageEvents();
            $view->displayEventForm();   
        } else {
            header('Location: /errors/403');
        }
    }

    public static function createEvent() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            if(UServer::getRequestMethod() === 'POST') {
                $title = UHTTPMethods::post('title');
                $fieldOfAction = UHTTPMethods::post('fieldOfAction');
                $coordinator = UHTTPMethods::post('coordinator');
                $date = UHTTPMethods::post('date');
                $time = UHTTPMethods::post('time');
                $place = UHTTPMethods::post('place');
                $requestedVolunteerNumber = UHTTPMethods::post('requestedVolunteerNumber');
                $maxVolunteerNumber = UHTTPMethods::post('maxVolunteerNumber');
                $candidateRequirements = UHTTPMethods::post('candidateRequirements');
                $description = UHTTPMethods::post('description');

                try {
                    $event = new EEvent($title, $date . ' ' . $time, $place, $coordinator, $requestedVolunteerNumber,
                            $maxVolunteerNumber, $fieldOfAction, $candidateRequirements, $description);
                    if(!($event->isScheduled())) {
                        throw new Exception('Choosen date for the event is not valid');
                    }
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('eventCreationError', $e->getMessage());
                    header('Location: /admin/errors/eventCreation');
                    return;
                }

                if(FPersistentManager::getInstance()->storeObject($event)) {
                    header('Location: /admin/confirmations/eventCreated');
                } else {
                    header('Location: /errors/500');
                }
            } else {
                header('Location: /admin/events/add');
            }
        } else {
            header('Location: /errors/403');
        }
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