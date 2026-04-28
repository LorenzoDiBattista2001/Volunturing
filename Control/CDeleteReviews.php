<?php

class CDeleteReviews {

    /**
     * Displays the admin's reviews management area
     * 
     * @return void
     */
    public static function accessReviewManagement() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            $reviews = FPersistentManager::getInstance()->retrieveAllReviews();
            $view = new VDeleteReviews();
            $view->displayReviewsList($reviews);
        } else {
            header('Location: /errors/403');
        }
    }

    /**
     * Removes the specified review from the database
     * 
     * This method checks whether the event the admin means to delete is currently scheduled
     * or not. If it is, an email is automatically created and sent to all users currently having
     * an application, either pending or already approved, to that event, and only then is the
     * event removed; otherwise, the event is simply removed from the database.
     * 
     * @param int $eventId The id of the event the admin is deleting
     * @return void
     */
    public static function deleteReview() : void {
        if(CUser::isLogged() && CUser::isAdmin()) {
            if(UServer::getRequestMethod() === 'POST') {
                $reviewId = UHTTPMethods::post('reviewId');
                $pm = FPersistentManager::getInstance();
                try {
                    if(empty($reviewId) || $reviewId < 0) {
                        throw new Exception('Illegal value for review id');
                    }   
                    if(!$pm->existObject(EReview::class, $reviewId)) {
                        throw new Exception('No review found with id ' . $reviewId);
                    }
                } catch (PDOException $e) {
                    header('Location: /errors/500');
                    return;
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