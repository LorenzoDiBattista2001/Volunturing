<?php

class CWriteReview {

    /**
     * Displays the form for writing a review
     * 
     * @return void
     */
    public static function writeReview() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VWriteReview();
            $view->displayReviewForm();
        } else {
            header('Location: ' . ROOT . '/errors/403');
        }
    }

    /**
     * Creates the review written by the user and stores it on the database
     * 
     * @return void
     */
    public static function publishReview() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            if(UServer::getRequestMethod() === 'POST') {
                $pm = FPersistentManager::getInstance();
                $text = UHTTPMethods::post('reviewText');
                $rating = UHTTPMethods::post('rating');
                try {
                    $review = new EReview($text, $rating, date('Y-m-d'));
                    $review->setUserId(USession::getInstance()->getSessionElement('user'));
                    if(!$pm->storeObject($review)) {
                        header('Location: ' . ROOT . '/errors/500');
                        return;
                    }
                    header('Location: ' . ROOT . '/confirmations/reviewPublished');
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('reviewPublishingError', $e->getMessage());
                    header('Location: ' . ROOT . '/errors/reviewPublishing');
                    return;
                }
            } else {
                header('Location: ' . ROOT . '/review/write');
            }
        } else {
            header('Location: ' . ROOT . '/errors/403');
        }
    }
}
?>