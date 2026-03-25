<?php

class CSubmitApplication {

    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        $view = new VSubmitApplication();
        $view->displayEventsList($scheduledEvents);
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        $view = new VSubmitApplication(CUser::isLogged());
        $view->displayEventDetails($event);
    }

    public static function startApplicationProcess(int $eventId) : void {
        if(CUser::isLogged()) {
            $view = new VSubmitApplication();
            $event = FPersistentManager::getInstance()->loadEvent($eventId);
            $user = FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user'));
            if (FPersistentManager::getInstance()->existApplication($user->getUserId(), $eventId)) {
                $view->displayEventDetails($event, alreadyApplied: true);
                exit();
            }
            if($event->isFull()) {
                $view->displayEventDetails($event, eventFull: true);
                exit();
             }
            $view->displayApplicationForm($event);
        } else {
            // display message for telling the user they need to log in before applying
            header('Location: /auth/loginForm');
        }
    }

    public static function createApplication(int $eventId) : void {
        if(UServer::getRequestMethod() === 'POST') {
            if(CUser::isLogged()) {
                $view = new VSubmitApplication();
                $message = UHTTPMethods::post('motivation');
                $application = new EApplication(date('Y-m-d H:i:s'), EApplicationState::WAITING, $message);
                $application->setUserId(USession::getInstance()->getSessionElement('user'));
                $application->setEventId($eventId);
                if(FPersistentManager::getInstance()->storeObject($application)) {
                    header('Location: /confirmations/applicationSubmitted');
                } else {
                    // display 500 error
                }
            } else {
                header('Location: /auth/loginForm');
            }
        } else {
            header('Location: /events/submitApplication/' . $eventId);
        }
    }

}

?>