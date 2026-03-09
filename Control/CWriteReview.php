<?php

class CWriteReview {

    public static function writeReview() : void {
        // check if user is logged in
        // check if user has at least one application completed
        // display form for writing a review
    }

    public static function publishReview(string $text, int $rating) : void {
        $pm = FPersistentManager::getInstance();
        $review = new EReview($text, $rating, (new DateTime('now'))->format('Y-m-d'));
        // retrieve user id from session variables
        $review->setUserId(1);
        $review->setAuthor($pm->loadUserById(1));
        $pm->storeObject($review);
    }
}
?>