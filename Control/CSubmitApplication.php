<?php

class CSubmitApplication {

    /**
     * Shows the currently scheduled events
     * 
     * @return void
     */
    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        $view = new VSubmitApplication();
        $view->displayEventsList($scheduledEvents);
    }

    /**
     * Shows the details of the selected event
     * 
     * This method retrieves the data associated with the event chosen by the user
     * and displays it, after verifying the event is currently scheduled.
     * 
     * @param int $eventId The id of the event whose details are to be displayed
     * @return void
     */
    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if(!$event->isScheduled()) {
            header('Location: /errors/403');
            return;
        }
        $view = new VSubmitApplication();
        $view->displayEventDetails($event);
    }

    /**
     * Displays the form for submitting an application
     * 
     * This method checks whether the user actually can submit an application
     * to a given event (i.e. he has not already applied to that event and
     * the event is not full) and launches the form for submitting the application. 
     * 
     * @param int $eventId The id of the event the user wants to participate in
     * @return void
     */
    public static function startApplicationProcess(int $eventId) : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VSubmitApplication();
            $pm = FPersistentManager::getInstance();
            $event = $pm->loadEvent($eventId);
            if(!$event->isScheduled()) {
                header('Location: /errors/403');
                return;
            }

            $user = $pm->loadUserById(USession::getInstance()->getSessionElement('user'));
            if ($pm->existApplication($user->getUserId(), $eventId)) {
                $view->displayEventDetails($event, alreadyApplied: true);
                exit();
            }
            if($event->isFull()) {
                $view->displayEventDetails($event, eventFull: true);
                exit();
             }
            $view->displayApplicationForm($event);
        } else {
            header('Location: /errors/loginRequired');
        }
    }

    /**
     * Creates and stores the application submitted by the user
     * 
     * @param int $eventId The id of the event for which the application was submitted
     * @return void
     */
    public static function createApplication(int $eventId) : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            if(UServer::getRequestMethod() === 'POST') {
                $view = new VSubmitApplication();
                $pm = FPersistentManager::getInstance();
                $event = $pm->loadEvent($eventId);
                if(!$event->isScheduled()) {
                    header('Location: /errors/403');
                    return;
                }

                $message = UHTTPMethods::post('motivation');
                $application = new EApplication(date('Y-m-d H:i:s'), EApplicationState::WAITING, $message);
                $application->setUserId(USession::getInstance()->getSessionElement('user'));
                $application->setEventId($eventId);

                if(!$pm->storeObject($application)) {
                    header('Location: /errors/500');
                    return;
                }

                header('Location: /confirmations/applicationSubmitted');
            } else {
                header('Location: /events/apply/' . $eventId);
            }
        } else {
            header('Location: /errors/403');
        }
    }

}

?>