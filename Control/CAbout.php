<?php

class CAbout {

    public static function showReviews() : void {
        $pm = FPersistentManager::getInstance();
        $reviews = $pm->retrieveAllReviews();
        $rating = $pm->retrieveAverageRating();
        $view = new VAbout();
        $view->displayReviewsList($reviews, $rating);
    }
}

?>