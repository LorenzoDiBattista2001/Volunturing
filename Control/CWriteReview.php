<?php

class CWriteReview {

    public static function writeReview() : void {
        if(CUser::isLogged()) {
            $view = new VWriteReview();
            $view->displayReviewForm();
        } else {
            header('Location: /errors/403');
        }
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