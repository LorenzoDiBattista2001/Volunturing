<?php

class VDeleteReviews {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays all the reviews stored on the database
     * 
     * @param array $reviews The reviews to be displayed
     */
    public function displayReviewsList($reviews) {
        $this->smarty->assign('reviews', $reviews);
        $this->smarty->assign('reviewsNumber', count($reviews));
        $this->smarty->display('reviewsManagement.tpl');
    }
}

?>