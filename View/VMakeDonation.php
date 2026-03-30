<?php

class VMakeDonation {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayDonationForm() {
        $this->smarty->display('donationForm.tpl');
    }

    public function displayPaymentForm(int $amount) {
        $this->smarty->assign('amount', $amount);
        $this->smarty->display('creditCardForm.tpl');
    }
}

?>