<?php

class CWithdrawApplication {

    public static function selectApplication(int $userId, int $eventId) : void {
        if(CUser::isLogged() && USession::getInstance()->getSessionElement('user') === $userId) {
            $pm = FPersistentManager::getInstance();
            if(!$pm->existApplication($userId, $eventId)) {
                header('Location: /errors/403');
                return;
            }
            $application = $pm->loadApplication($userId, $eventId);
            $event = $application->getEvent();
            $view = new VWithdrawApplication();
            $view->displayApplicationPanel($application, $event);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function withdrawApplication(int $userId, int $eventId) : void {
        if(CUser::isLogged() && USession::getInstance()->getSessionElement('user') === $userId) {
            $pm = FPersistentManager::getInstance();
            if(!$pm->existApplication($userId, $eventId)) {
                header('Location: /errors/403');
                return;
            }
            $application = $pm->loadApplication($userId, $eventId);
            try {
                $application->withdraw();
                if(!$pm->updateApplication($application)) {
                    header('Location: /errors/500');
                    return;
                }
            } catch (Exception $e) {
                USession::getInstance()->setSessionElement('applicationWithdrawalError', $e->getMessage());
                header('Location: /errors/applicationWithdrawal');
                return;
            }
            header('Location: /confirmations/applicationWithdrawn/' . $eventId);
        } else {
            header('Location: /errors/403');
        }
    }
}

?>