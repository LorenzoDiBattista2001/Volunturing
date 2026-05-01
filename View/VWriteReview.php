<?php

class VWriteReview {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the form for writing a review
     */
    public function displayReviewForm() {
        $this->smarty->display('reviewForm.tpl');
    }
}

?>