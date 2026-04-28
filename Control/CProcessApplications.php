<?php

class CProcessApplications {

    /**
     * Displays the admin's applications processing area
     * 
     * @return void
     */
    public static function accessApplicationManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $events = FPersistentManager::getInstance()->retrieveScheduledEventsWithApplications();
            $view = new VProcessApplications();
            $view->displayEventsList($events);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Displays the event's details and associated list of pending applications
     * 
     * @param int $eventId The id of the event whose pending applications are to be listed
     * @return void
     */
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

    /**
     * Displays a specific application's details and management options
     * 
     * @param int $eventId The id of the event the application was submitted for
     * @param int $userId The id of the user who submitted the application
     * @return void
     */
    public static function selectApplication(int $eventId, int $userId) : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $application = FPersistentManager::getInstance()->loadApplication($userId, $eventId);
            $view = new VProcessApplications();
            $view->displayApplicationDetails($application);
        } else {
            header('Location: /errors/403');
        }

    }

    /**
     * Approves a user's application to a given event
     * 
     * This method operates as follows: first, it grants the admin exclusive
     * access to the database row where the event is stored; this is in order
     * to prevent race conditions if two or more admins are processing different
     * applications for the same event while there is only one slot available.
     * Second, it tries to set the application's state to 'approved' and, if
     * successful, checks whether the event is now full (after reloading it
     * from the database to avoid any risks of inconsistency). If it is, then
     * all pending applications left are automatically rejected within the
     * transaction.
     * 
     * @param int $eventId The id of the event the application was submitted for
     * @param int $userId The id of the user who submitted the application
     * @return void
     */
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
                $db->rollBack();
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

    /**
     * Rejects a user's application to a given event
     * 
     * This method ensures a reason for rejecting the application
     * has been provided, tries to set the application's state to
     * 'rejected' and to update its state on the database. If successful,
     * it redirects the admin to the pending applications page for the
     * same event.
     * 
     * @param int $eventId The id of the event the application was submitted for
     * @param int $userId The id of the user who submitted the application
     * @return void
     */
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

    /**
     * Rejects all pending applications left after the maximum volunteers number is reached
     * 
     * @param \EEvent $event The event which the applications to be rejected had been submitted for
     * @return void
     */
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