<?php

class CProcessApplications {

    public static function accessApplicationManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $events = FPersistentManager::getInstance()->retrieveScheduledEventsWithApplications();
            $view = new VProcessApplications();
            $view->displayEventsList($events);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function inspectEvent(int $eventId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $pm = FPersistentManager::getInstance();
            $view = new VProcessApplications();

            $event = $pm->loadEvent($eventId);
            $applications = $event->getPendingApplications();
            
            $view->displayApplicationsList($event, $applications);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function selectApplication(int $eventId, int $userId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $application = FPersistentManager::getInstance()->loadApplication($userId, $eventId);
            $view = new VProcessApplications();
            $view->displayApplicationDetails($application);
        } else {
            header('Location: /errors/403');
        }

    }

    public static function approveApplication(int $eventId, int $userId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $pm = FPersistentManager::getInstance();
            $db = FConnectionDB::getInstance();

            try {
                $db->beginTransaction();

                $event = $pm->loadEventForUpdate($eventId);
                $application = $pm->loadApplication($userId, $eventId);
                $application->setEvent($event);

                $application->approve();

                if(!$pm->updateApplication($application)) {
                    throw new Exception('Error occurred while updating the application');
                } 

                // reload event after the application was updated
                $event = $pm->loadEvent($eventId);
                if($event->isFull()) {
                    self::rejectAllApplications($event);
                }
                $db->commit();

                header('Location: /admin/applications/process/' . $event->getEventId());

            } catch(PDOException $pe) {
                header('Location: /errors/500');
            } catch(Exception $e) {
                $db->rollBack();
                USession::getInstance()->setSessionElement('applicationProcessingError', $e->getMessage());
                header('Location: /admin/errors/applicationProcessing');
                return;
            }
        } else {
            header('Location: /errors/403');
        }
    }

    public static function rejectApplication(int $eventId, int $userId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            if(UServer::getRequestMethod() === 'POST') {
                $pm = FPersistentManager::getInstance();
                $reason = UHTTPMethods::post('reasonForRejection');

                $application = $pm->loadApplication($userId, $eventId);
                try {
                    if(empty($reason)) {
                        throw new Exception('Reason for rejection is required when rejecting an application');
                    }
                    $application->reject($reason);
                } catch(Exception $e) {
                    USession::getInstance()->setSessionElement('applicationProcessingError', $e->getMessage());
                    header('Location: /admin/errors/applicationProcessing');
                    return;
                }
                
                if(!$pm->updateApplication($application)) {
                    header('Location: /errors/500');
                    return;
                }

                header('Location: /admin/applications/process/' . $application->getEventId());
            } else {
                header('Location: /admin/applications/select/' . $eventId . '/' . $userId);
            }
        } else {
            header('Location: /errors/403');
        }
    }

    private static function rejectAllApplications(EEvent $event) : void {
        $pm = FPersistentManager::getInstance();
        $pendingApplications = $event->getPendingApplications();

        foreach($pendingApplications as $application) {
            $application->reject('POSTI ESAURITI');
            if(!$pm->updateApplication($application)) {
                throw new Exception('Error occurred while trying to update applications');
            }
        }
    }
}
?>