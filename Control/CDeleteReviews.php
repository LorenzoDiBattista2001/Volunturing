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

    public static function deleteReview() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            if(UServer::getRequestMethod() === 'POST') {
                $reviewId = UHTTPMethods::post('reviewId');
                try {
                    $pm = FPersistentManager::getInstance();
                    if(empty($reviewId) || $reviewId < 0) {
                        throw new Exception('Illegal value for review id');
                    }   
                    if(!$pm->existObject(EReview::class, $reviewId)) {
                        throw new Exception('No review found with id ' . $reviewId);
                    }
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('reviewDeletionError', $e->getMessage());
                    header('Location: /admin/errors/reviewDeletion');
                    return;
                }
                if(!$pm->deleteObject(EReview::class, $reviewId)) {
                        header('Location: /errors/500');
                        return;
                }
                header('Location: /admin/reviews/manage');
            } else {
                header('Location: /admin/reviews/manage');
            }
        } else {
            header('Location: /errors/403');
        }
    }
}
?>