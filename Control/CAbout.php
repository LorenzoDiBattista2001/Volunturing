<?php

class CAbout {

    /**
     * Retrieves and displays all users' reviews
     * 
     * @return void
     */
    public static function showReviews() : void {
        $pm = FPersistentManager::getInstance();
        $reviews = $pm->retrieveAllReviews();
        $rating = $pm->retrieveAverageRating();
        $view = new VAbout();
        $view->displayReviewsList($reviews, $rating);
    }

    /**
     * Displays the web application's 'contacts' page
     * 
     * @return void
     */
    public static function showContacts() : void {
        $view = new VAbout();
        $view->displayContactsPage();
    }

    /**
     * Displays the web application's info page
     * 
     * @return void
     */
    public static function showAssociationInfo() : void {
        $view = new VAbout();
        $view->displayAssociationInfo();
    }
}

?>