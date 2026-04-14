<?php

class CDeleteReviews {

    public static function accessReviewManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $reviews = FPersistentManager::getInstance()->retrieveAllReviews();
            $view = new VDeleteReviews();
            $view->displayReviewsList($reviews);
        } else {
            header('Location: /errors/403');
        }
    }

    public static function deleteReview(int $review) : void {

    }
}
?>