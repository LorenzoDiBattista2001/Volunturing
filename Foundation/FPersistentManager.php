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

    /**
     * Stores an object on the database
     * 
     * @param object $obj The entity object to be stored
     * @return bool true on success, false otherwise
     */
    public function storeObject(object $obj) : bool {

        $class = get_class($obj);

        if($class === 'EVolunteer' || $class === 'EAdmin') {
            $fclass = 'FUser';
        } else {
            $fclass = 'F' . substr($class, 1);
        }
        
        return $fclass::store($obj);
    }

    /**
     * Removes an object from the database
     * 
     * @param string $className The class name of the entity object to be removed
     * @param int $objectId The id of the object
     * @return bool true on success, false otherwise
     */
    public function deleteObject(string $className, int $objectId) : bool {

        if($className === 'EVolunteer' || $className === 'EAdmin') {
            $fclass = 'FUser';
        } else {
            $fclass = 'F' . substr($className, 1);
        }

        return $fclass::delete($objectId);
    }

    public function loadEvent(int $eventId) : EEvent {
        $event = FEvent::load($eventId);
        $event->setApplications($this->retrieveApplicationsByEvent($event));
        return $event;
    }

    public function loadEventForUpdate(int $eventId) : EEvent {
        $event = FEvent::loadForUpdate($eventId);
        $event->setApplications($this->retrieveApplicationsByEvent($event));
        return $event;
    }

    public function retrieveAllEvents() {
        return FEvent::loadAllEvents();
    }

    public function retrieveScheduledEvents() {
        $currentDate = date('Y-m-d');
        return FEvent::loadEventsByDate($currentDate);
    }

    public function retrieveScheduledEventsWithApplications() {
        $events = $this->retrieveScheduledEvents();
        foreach($events as $event) {
            $event->setApplications(FApplication::loadByEvent($event->getEventId()));
        }
        return $events;
    }

    public function loadUserById(int $userId, bool $full = true) : EUser {
        $user = FUser::loadById($userId);
        // if($user::class === 'EAdmin') return $user;
        // return $this->loadVolunteer($user);

        return ((($user::class === 'EAdmin') || !$full) ? $user : $this->loadVolunteer($user));
    }

    public function loadUserByEmail(string $email) : EUser {
        $user = FUser::loadByEmail($email);
        if($user::class === 'EAdmin') return $user;
        return $this->loadVolunteer($user);
    }

    private function loadVolunteer(EVolunteer $volunteer) : EVolunteer {
        $volunteer->setApplications($this->retrieveApplicationsByUser($volunteer));
        $volunteer->setReviews($this->retrieveReviewsByUser($volunteer));
        $volunteer->setDonations($this->retrieveDonationsByUser($volunteer));
        return $volunteer;
    }

    public function retrieveRegisteredUsers() {
        return FUser::loadAllVolunteers();
    }

    public function loadApplication(int $userId, int $eventId) : EApplication {
        $application = FApplication::load($userId, $eventId);
        $application->setCandidate($this->loadUserById($application->getUserId()));
        $application->setEvent($this->loadEvent($application->getEventId()));
        
        return $application;
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

    /**
     * Retrieves an array of application objects based on the id of the event they were submitted for
     * 
     * @param \EEvent $event The event the applications were submitted for
     */
    public function retrieveApplicationsByEvent(EEvent $event) {

        $applications = FApplication::loadByEvent($event->getEventId());
        
        foreach($applications as $application) {
            $application->setEvent($event); // consider deleting line
            $application->setCandidate(FUser::loadById($application->getUserId()));
        }

        return $applications;
    }

    /**
     * Retrieves an array of application objects based on the id of the candidate
     * 
     * @param \EVolunteer $candidate The volunteer who submitted the applications
     */
    public function retrieveApplicationsByUser(EVolunteer $candidate) {

        $applications = FApplication::loadByUser($candidate->getUserId());
        
        foreach($applications as $application) {
            $application->setEvent(FEvent::load($application->getEventId()));
            $application->setCandidate($candidate); // consider deleting line
        }

        return $applications;
    }

    /**
     * Retrieves all the reviews stored on the database along with their authors
     */
    public function retrieveAllReviews() {
        $reviews = FReview::loadAllReviews();

        foreach($reviews as $review) {
            $review->setAuthor($this->loadUserById($review->getUserId(), false));
        }

        return $reviews;
    }

    /**
     * Retrieves all the reviews written by a given user
     * 
     * @param \EVolunteer $author The volunteer who wrote the reviews to be fetched
     */
    public function retrieveReviewsByUser(EVolunteer $author) {

        $reviews = FReview::loadByUser($author->getUserId());

        foreach($reviews as $review) {
            $review->setAuthor($author);
        }

        return $reviews;
    }

    /**
     * Retrieves all the donations made by a given user
     * 
     * @param \EVolunteer $donator The volunteer whose donations are to be fetched
     */
    public function retrieveDonationsByUser(EVolunteer $donator) {

        $donations = FDonation::loadByUser($donator->getUserId());

        foreach($donations as $donation) {
            $donation->setDonator($donator);
        }

        return $donations;
    }

    public function updateApplication(EApplication $application) : bool {
        return FApplication::update($application);
    }

    public function updateUserPassword(int $userId, string $password) : bool {
        return FUser::updatePassword($userId, $password);
    }

    public function updateUserEmail(int $userId, string $email) : bool {
        return FUser::updateEmail($userId, $email);
    }

    /**
     * Updates a volunteer's account information
     * 
     * @param \EVolunteer $volunteer The volunteer whose account information is to be updated
     * @return bool true on success, false otherwise
     */
    public function updateUserProfile(EVolunteer $volunteer) : bool {
        return FUser::updateProfile($volunteer);
    }

    /**
     * Updates the state of a volunteer's profile
     * 
     * @param \EVolunteer $volunteer The volunteer whose state is to be updated
     * @return bool true on success, false otherwise
     */
    public function updateVolunteerState(EVolunteer $volunteer) : bool {
        return FUser::updateVolunteerState($volunteer);
    }

    /**
     * Checks for the existence of an object of a given class based on ad id
     * 
     * @param string $class The class name of the object to check the existence of
     * @param int $objectId The id of the object to check the existence of
     * @return bool true if the object exists, false otherwise
     */
    public function existObject(string $class, int $objectId) : bool {

        $fclass = 'F' . substr($class, 1);
        return $fclass::exist($objectId);
    }

    /**
     * Checks for the existence of an application based on the IDs of a user and of an event
     * 
     * @param int $userId The id of the user whose application to check the existence of
     * @param int $eventId The id of the event which the application whose existence is to be checked belongs to
     * @return bool true if the application exists, false otherwise
     */
    public function existApplication(int $userId, int $eventId) : bool {
        return FApplication::exist($userId, $eventId);
    }

    /**
     * Retrieves statistics for the admin's dashboard
     */
    public function loadDashboardData() {
        $data = array();

        $data[] = FEvent::getScheduledEventsNumber();
        $data[] = FApplication::getPendingApplicationsNumber();
        $data[] = FUser::getVolunteersCount();
        
        return $data;
    }

    /**
     * Retrieves the mean of the ratings of all the reviews stored on the database
     * 
     * @return int The average rating expressed by the volunteers
     */
    public function retrieveAverageRating() : int {
        return FReview::getAverageRating();
    }

    /**
     * Retrieves the number of reviews stored on the database
     * 
     * @return int The total number of reviews stored on the database
     */
    public function retrieveReviewsNumber() : int {
        return FReview::getReviewsNumber();
    }

    /**
     * Checks whether a given email address belongs to a registered user
     * 
     * @param string $email The email address to check the existence of
     * @return bool true if the email address belongs to a registered user, false otherwise
     */
    public function emailExist(string $email) : bool {
        return FUser::emailExist($email);
    }

    public function newEmailExist(string $email, int $userId) : bool {
        return FUser::newEmailExist($email, $userId);
    }
}

?>