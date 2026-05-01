<?php

class VAbout {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the page with all the reviews written by volunteers
     */
    public function displayReviewsList($reviews, int $rating) {
        $this->smarty->assign('reviews', $reviews);
        $this->smarty->assign('rating', $rating);
        $this->smarty->assign('reviewsNumber', count($reviews));
        $this->smarty->display('reviews.tpl');
    }

    /**
     * Renders the web application's 'contacts' page
     */
    public function displayContactsPage() {
        $this->smarty->display('contacts.tpl');
    }

    /**
     * Renders the web application's info page
     */
    public function displayAssociationInfo() {
        $this->smarty->display('associationInfo.tpl');
    }
}

?>