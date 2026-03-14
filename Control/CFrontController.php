<?php

class CFrontController {

    private static $adminMap = array(
        'events' => ['CManageEvents', array(
            'manage' => 'accessEventManagement',
            'add' => 'addEvent',
            'create' => 'createEvent',
            'select' => 'selectEvent',
            'delete' => 'deleteEvent'
        )],
        'applications' => ['CProcessApplications', array(
            'manage' => 'accessApplicationManagement',
            'process' => 'inspectEvent',
            'select' => 'selectApplication',
            'approve' => 'approveApplication',
            'reject' => 'rejectApplication'
        )],
        'users' => ['CManageUsers', array(
            'manage' => 'accessUserManagement',
            'select' => 'selectUser',
            'block' => 'blockUser',
            'confirmBlocking' => 'performUserBlocking',
            'unlock' => 'unlockUser' 
        )],
        'reviews' => ['CDeleteReviews', array(
            'manage' => 'accessReviewManagement',
            'delete' => 'deleteReview',
            'confirmDeletion' => 'performDeletion'
        )] 
    );

    private static $volunteersMap = array(
        'events' => ['CSubmitApplication', array(
            'explore' => 'showEvents',
            'detail' => 'selectEvent',
            'apply' => 'startApplicationProcess',
            'submitApplication' => 'createApplication'
        )],
        'applications' => ['CWithdrawApplication', array(
            'select' => 'selectApplication',
            'withdraw' => 'withdrawApplication',
            'confirmWithdrawal' => 'performWithdrawal'
        )],
        'donation' => ['CMakeDonation', array(
            'start' => 'donate',
            'amount' => 'insertAmount',
            'confirm' => 'confirmDonation'
        )],
        'review' => ['CWriteReview', array(
            'write' => 'writeReview',
            'publish' => 'publishReview'
        )]
    );

    public function run() : void {
        $requestURI = UServer::getRequestURI();
        $temp = str_replace(ROOT, '', $requestURI);
        $URIElements = explode('/', trim($temp, '/'));

        if($URIElements[0] === 'admin') {
            $this->handleAdminRequests(array_slice($URIElements, 1));
        } else {
            $this->handleVolunteersRequests($URIElements);
        }
    }

    private function handleAdminRequests(array $elements) : void {
        if(count($elements) < 2) {
            // display 404 error
            return;
        }

        $resource = $elements[0];
        $action = $elements[1];

        if(isset(self::$adminMap[$resource]) && isset(self::$adminMap[$resource][1][$action])) {
            $controller = self::$adminMap[$resource][0];
            $method = self::$adminMap[$resource][1][$action];
            $params = array_slice($elements, 2);

            if(class_exists($controller) && method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                // display 404 error
                print('Controllore o Metodo non trovato');
            }
        } else {
            // display 404 error
            print('URL non valida');
        }
    }

    private function handleVolunteersRequests(array $elements) : void {
        if(count($elements) < 2) {
            // display 404 error
            return;
        }

        $resource = $elements[0];
        $action = $elements[1];

        if(isset(self::$volunteersMap[$resource]) && isset(self::$volunteersMap[$resource][1][$action])) {
            $controller = self::$volunteersMap[$resource][0];
            $method = self::$volunteersMap[$resource][1][$action];
            $params = array_slice($elements, 2);

            if(class_exists($controller) && method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                // display 404 error
                print('Controllore o Metodo non trovato');
            }
        } else {
            // display 404 error
            print('URL non valida');
        }
    }
}

?>