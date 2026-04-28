<?php

class CManageEvents {

    /**
     * Displays the admin's events management area
     * 
     * Retrieves all the events stored on the database (including past 
     * events waiting to be removed) for the admin to act upon.
     * 
     * @return void
     */
    public static function accessEventManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $events = FPersistentManager::getInstance()->retrieveAllEvents();
            $view = new VManageEvents();
            $view->displayEventsList($events);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Displays the form for creating an event
     * 
     * @return void
     */
    public static function addEvent() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VManageEvents();
            $view->displayEventForm();   
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Creates the event and stores it on the database
     * 
     * Extracts the event's details specified by the admin from the form fields, 
     * tries to instantiate an event object and saves it on the database
     * 
     * @return void
     */
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
                        throw new Exception('La data dell\'evento non può appartenere al passato');
                    }
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('eventCreationError', $e->getMessage());
                    header('Location: /admin/errors/eventCreation');
                    return;
                }

                if(!FPersistentManager::getInstance()->storeObject($event)) {
                    header('Location: /errors/500');
                    return;
                }

                header('Location: /admin/confirmations/eventCreated');
            } else {
                header('Location: /admin/events/add');
            }
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Displays an event's details and management options
     * 
     * @param int $eventId The id of the event the admin wants to act upon
     * @return void
     */
    public static function selectEvent(int $eventId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $event = FPersistentManager::getInstance()->loadEvent($eventId);
            $view = new VManageEvents();
            $view->displayEventPanel($event);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Removes the specified event from the database
     * 
     * This method checks whether the event the admin means to delete is currently scheduled
     * or not. If it is, an email is automatically created and sent to all users currently having
     * an application, either pending or already approved, to that event, and only then is the
     * event removed; otherwise, the event is simply removed from the database.
     * 
     * @param int $eventId The id of the event the admin is deleting
     * @return void
     */
    public static function deleteEvent(int $eventId) {
        if(CUser::isLogged() && CUser::isAdmin()) {
            if(UServer::getRequestMethod() === 'POST') {
                $pm = FPersistentManager::getInstance();
                $event = $pm->loadEvent($eventId);

                try {
                    if($event->isScheduled()) {
                        $reasonForDeletion = UHTTPMethods::post('reasonForDeletion');
                        if(!isset($reasonForDeletion) || $reasonForDeletion === '') {
                            throw new Exception('Per eliminare un evento programmato, è necessario inserire una motivazione');
                        } 
                    }

                    if(!$pm->deleteObject(EEvent::class, $eventId)) {
                        header('Location: /errors/500');
                        return;
                    }
                    
                    if($event->isScheduled()) {
                        $view = new VEmail();
                        $subject = 'Volontorino OdV - Avviso Cancellazione Evento';
                        $body = $view->generateEventCancellationEmail($event, $reasonForDeletion);
                        $currentApplications = $event->getCurrentApplications();
                        foreach($currentApplications as $application) {
                            $candidate = $application->getCandidate();
                            if(!UEmail::sendEmail($candidate->getEmail(), $candidate->getFirstName(), $subject, $body)) {
                                throw new Exception('Failed to send emails to all volunteers involved');
                            }
                        }
                        header('Location: /admin/confirmations/scheduledEventDeleted');
                        return;
                    }
                    header('Location: /admin/confirmations/eventDeleted');
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('eventDeletionError', $e->getMessage());
                    header('Location: /admin/errors/eventDeletion');
                    return;
                }
            } else {
                header('Location: /admin/events/select/' . $eventId);
            }
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Displays the list of volunteers whose applications to the event have
     * been approved (and not withdrawn thereafter).
     *
     * @param int $eventId The id of the event whose participants are to be displayed
     * @return void
     */
    public static function showVolunteersList(int $eventId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $view = new VManageEvents();
            $event = FPersistentManager::getInstance()->loadEvent($eventId);
            $participants = $event->getParticipants();
            $view->displayVolunteersList($event, $participants);
        } else {
            header('Location: /errors/403');
        }
    }
}

?>