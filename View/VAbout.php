<?php

class VAbout {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayReviewsList($reviews, int $rating) {
        $this->smarty->assign('reviews', $reviews);
        $this->smarty->assign('rating', $rating);
        $this->smarty->assign('reviewsNumber', count($reviews));
        $this->smarty->display('reviews.tpl');
    }
}

?>