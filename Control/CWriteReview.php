<?php

class CWriteReview {

    public static function writeReview() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VWriteReview();
            $view->displayReviewForm();
        } else {
            header('Location: /errors/403');
        }
    }

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
                        header('Location: /errors/500');
                        return;
                    }
                    header('Location: /confirmations/reviewPublished');
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('reviewPublishingError', $e->getMessage());
                    header('Location: /errors/reviewPublishing');
                    return;
                }
            } else {
                header('Location: /review/write');
            }
        } else {
            header('Location: /errors/403');
        }
    }
}
?>