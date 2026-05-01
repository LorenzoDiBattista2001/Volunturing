<?php

class VMakeDonation {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the form for inserting the amount and the reason for a donation
     */
    public function displayDonationForm() {
        $this->smarty->display('donationForm.tpl');
    }

    /**
     * Displays the form for inserting the credit card details
     * 
     * @param int $amount The amount of money the user means to donate to the volunteering association
     */
    public function displayPaymentForm(int $amount) {
        $this->smarty->assign('amount', $amount);
        $this->smarty->display('creditCardForm.tpl');
    }
}

?>