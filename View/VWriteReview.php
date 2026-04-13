<?php

class VWriteReview {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayReviewForm() {
        $this->smarty->display('reviewForm.tpl');
    }
}

?>