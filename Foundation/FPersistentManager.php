<?php

class FPersistentManager {

    private static $instance;

    private function __construct() {

    }

    public static function getInstance() : FPersistentManager {
        if(!isset(self::$instance)) {
            self::$instance = new FPersistentManager();
        }
        return self::$instance;
    }

    public function storeObject(object $obj) : bool {

        $class = get_class($obj);

        if($class === 'EVolunteer' || $class === 'EAdmin') {
            $fclass = 'FUser';
        } else {
            $fclass = 'F' . substr($class, 1);
        }
        
        return $fclass::store($obj);
    }

    public function loadEvent(int $eventId) : EEvent {
        $event = FEvent::load($eventId);
        $event->setApplications($this->retrieveApplicationsByEvent($event));
        return $event;
    }

    public function loadUserById(int $userId) : EUser {
        $user = FUser::loadById($userId);
        if($user::class === 'EAdmin') return $user;
        return $this->loadVolunteer($user);
    }

    private function loadVolunteer(EVolunteer $volunteer) : EVolunteer {
        $volunteer->setApplications($this->retrieveApplicationsByUser($volunteer));
        $volunteer->setReviews($this->retrieveReviewsByUser($volunteer));
        $volunteer->setDonations($this->retrieveDonationsByUser($volunteer));
        return $volunteer;
    }

    public function loadReview(int $reviewId) : EReview {
        $review = FReview::load($reviewId);
        $review->setAuthor($this->loadUserById($review->getUserId()));
        return $review;
    }

    public function loadDonation(int $donationId) : EDonation {
        $donation = FDonation::load($donationId);
        $donation->setDonator($this->loadUserById($donation->getUserId()));
        return $donation;
    }

    public function retrieveApplicationsByEvent(EEvent $event) {

        $applications = FApplication::loadByEvent($event->getEventId());
        
        foreach($applications as $application) {
            $application->setEvent($event);
            $application->setCandidate(FUser::loadById($application->getUserId()));
        }

        return $applications;
    }

    public function retrieveApplicationsByUser(EVolunteer $candidate) {

        $applications = FApplication::loadByUser($candidate->getUserId());
        
        foreach($applications as $application) {
            $application->setEvent(FEvent::load($application->getEventId()));
            $application->setCandidate($candidate);
        }

        return $applications;
    }

    public function retrieveReviewsByUser(EVolunteer $author) {

        $reviews = FReview::loadByUser($author->getUserId());

        foreach($reviews as $review) {
            $review->setAuthor($author);
        }

        return $reviews;
    }

    public function retrieveDonationsByUser(EVolunteer $donator) {

        $donations = FDonation::loadByUser($donator->getUserId());

        foreach($donations as $donation) {
            $donation->setDonator($donator);
        }

        return $donations;
    }

    public function existObject(string $class, int $objectId) : bool {

        $fclass = 'F' . substr($class, 1);
        return $fclass::exist($objectId);
    }

    public function existApplication(int $userId, int $eventId) : bool {
        return FApplication::exist($userId, $eventId);
    }

}

?>