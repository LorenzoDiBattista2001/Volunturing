<?php

class CSubmitApplication {

    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        $view = new VSubmitApplication();
        $view->displayEventsList($scheduledEvents);
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if(!$event->isScheduled()) {
            header('Location: /errors/403');
            return;
        }
        $view = new VSubmitApplication(CUser::isLogged());
        $view->displayEventDetails($event);
    }

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