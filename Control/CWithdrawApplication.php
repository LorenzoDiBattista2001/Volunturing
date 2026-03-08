<?php

class CWithdrawApplication {

    public static function selectApplication(int $userId, int $eventId) : void {
        // check if user is logged in
        $application = FPersistentManager::getInstance()->loadApplication($userId, $eventId);
        print($application->getState()->value);
        // display application details
    }

    public static function withdrawApplication() : void {
        // check if application is 'rejected' or 'withdrawn'
        // display warning and confirmation request message
    }

    public static function performWithdrawal(int $userId, int $eventId) : void {
        $pm = FPersistentManager::getInstance();
        $application = $pm->loadApplication($userId, $eventId);
        $application->withdraw();
        if($pm->updateApplication($application)) {
            // display confirmation message
        } else {
            // display error message
        }
    }
}

?>