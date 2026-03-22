<?php

class VUser {

    private $smarty;

    public function __construct(bool $isLogged) {
        $this->smarty = VStartSmarty::configuration();
        $this->smarty->assign('isLogged', $isLogged);
    }

    public function displayHomePage() {
        $this->smarty->display('home.tpl');
    }

    public function displayLoginForm() {
        $this->smarty->display('loginForm.tpl');
    }

    public function displayRegistrationForm() {
        $this->smarty->display('registrationForm.tpl');
    }

    public function displayVolunteerPersonalArea(EVolunteer $volunteer) {
        $this->smarty->assign('volunteer', $volunteer);
        $this->smarty->assign('applications', $volunteer->getApplications());
        $this->smarty->assign('donations', $volunteer->getDonations());
        $this->smarty->assign('reviews', $volunteer->getReviews());
        $this->smarty->display('volunteerPersonalArea.tpl');
    }
}

?>