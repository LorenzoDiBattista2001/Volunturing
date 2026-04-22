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

    public static function selectEvent(int $eventId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $event = FPersistentManager::getInstance()->loadEvent($eventId);
            $view = new VManageEvents();
            $view->displayEventPanel($event);
        } else {
            header('Location: /errors/403');
        }
    }

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