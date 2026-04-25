<?php

class CFrontController {

    private static $adminMap = array(
        'events' => ['CManageEvents', array(
            'manage' => 'accessEventManagement',
            'add' => 'addEvent',
            'create' => 'createEvent',
            'select' => 'selectEvent',
            'delete' => 'deleteEvent',
            'participants' => 'showVolunteersList'
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
            'unlock' => 'unlockUser' 
        )],
        'reviews' => ['CDeleteReviews', array(
            'manage' => 'accessReviewManagement',
            'delete' => 'deleteReview'
        )],
        'confirmations' => ['CConfirmationMessage', array(
            'eventCreated' => 'confirmEventCreation',
            'eventDeleted' => 'confirmEventDeletion',
            'scheduledEventDeleted' => 'confirmScheduledEventDeletion',
            'userBlocked' => 'confirmUserBlocking',
            'userUnlocked' => 'confirmUserUnlocking'
        )],
        'errors' => ['CError', array(
            'applicationProcessing' => 'handleApplicationProcessingErrors',
            'eventCreation' => 'handleEventCreationErrors',
            'eventDeletion' => 'handleEventDeletionErrors',
            'userBlocking' => 'handleUserBlockingErrors',
            'userUnlocking' => 'handleUserUnlockingErrors',
            'reviewDeletion' => 'handleReviewDeletionErrors'
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
        )],
        'confirmations' => ['CConfirmationMessage', array(
            'applicationSubmitted' => 'confirmApplicationSubmission',
            'applicationWithdrawn' => 'confirmApplicationWithdrawal',
            'donationPerformed' => 'confirmDonationReception',
            'reviewPublished' => 'confirmReviewPublishing',
            'passwordChanged' => 'confirmPasswordChange',
            'emailChanged' => 'confirmEmailChange',
            'profileUpdated' => 'confirmProfileUpdate',
            'logout' => 'confirmLogout'
        )],
        'errors' => ['CError', array(
            '403' => 'handleAccessForbiddenError',
            '404' => 'handlePageNotFoundError',
            '500' => 'handleInternalServerError',
            'donation' => 'handleDonationErrors',
            'applicationWithdrawal' => 'handleApplicationWithdrawalErrors',
            'reviewPublishing' => 'handleReviewPublishingErrors',
            'changePassword' => 'handleChangePasswordErrors',
            'changeEmail' => 'handleChangeEmailErrors',
            'profileUpdate' => 'handleProfileUpdateErrors',
            'registration' => 'handleRegistrationErrors',
            'login' => 'handleLoginErrors',
            'loginRequired' => 'handleLoginRequiredError'
        )],
        'about' => ['CAbout', array(
            'reviews' => 'showReviews'
        )]
    );

    private static $userMap = array(
        'login' => 'performLogin',
        'register' => 'register',
        'loginForm' => 'authenticate',
        'registrationForm' => 'startRegistration',
        'logout' => 'performLogout',
        'personal' => 'accessPersonalArea',
        'changePassword' => 'changePassword',
        'changeEmail' => 'changeEmail',
        'manage' => 'manageAccount',
        'update' => 'updateProfile'
    );

    public function run() : void {
        set_exception_handler([self::class, 'globalExceptionHandler']);

        $requestURI = UServer::getRequestURI();
        $this->checkHTTPS($requestURI);

        $URIElements = explode('/', trim($requestURI, '/'));

        if($URIElements[0] === '') {
            call_user_func([CUser::class, 'showHome']);
        } elseif($URIElements[0] === 'admin') {
            $this->handleAdminRequests(array_slice($URIElements, 1));
        } elseif ($URIElements[0] === 'auth' || $URIElements[0] === 'account') {
            $this->handleSystemOperations(array_slice($URIElements, 1));
        } else {
            $this->handleVolunteersRequests($URIElements);
        }
    }

    private function handleAdminRequests(array $elements) : void {
        if(!CUser::isLogged() || !CUser::isAdmin()) {
            header('Location: /errors/403');
            return;
        }

        if(count($elements) < 2) {
            header('Location: /errors/404');
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
                header('Location: /errors/404');
            }
        } else {
            header('Location: /errors/404');
        }
    }

    private function handleVolunteersRequests(array $elements) : void {
        if(count($elements) < 2) {
            header('Location: /errors/404');
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
                header('Location: /errors/404');
            }
        } else {
            header('Location: /errors/404');
        }
    }

    private function handleSystemOperations(array $elements) : void {
        if(count($elements) < 1) {
            header('Location: /errors/404');
            return;
        }

        $action = $elements[0];

        if(isset(self::$userMap[$action])) {
            $method = self::$userMap[$action];
            $params = array_slice($elements, 1);

            if(method_exists(CUser::class, $method)) {
                call_user_func_array([CUser::class, $method], $params);
            } else {
                header('Location: /errors/404');
            }
        } else {
            header('Location: /errors/404');
        }
    }

    private function checkHTTPS(string $requestURI) : void {
        $https = UServer::getEntryByKey('HTTPS');
        $forwarded = UServer::getEntryByKey('HTTP_X_FORWARDED_PROTO');
    
        $isHttps = (!empty($https) && $https !== 'off') || $forwarded === 'https';

        if (!$isHttps) {
            $location = 'https://' . UServer::getEntryByKey('HTTP_HOST') . $requestURI;
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $location);
            exit();
        }
    }

    public static function globalExceptionHandler(Throwable $exception) : void {
        error_log("Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " at row " . $exception->getLine());
        header('Location: /errors/500');
        exit();
    }
}

?>