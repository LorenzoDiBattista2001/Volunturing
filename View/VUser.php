<?php

class VUser {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
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

    public function displayVolunteerAccountManagement(EVolunteer $volunteer) {
        $this->smarty->assign('user', $volunteer);
        $this->smarty->display('updateProfile.tpl');
    }

    public function displayAdminDashboard(EAdmin $admin, $dashboardData) {
        $this->smarty->assign('firstName', $admin->getFirstName());
        $this->smarty->assign('lastName', $admin->getLastName());
        $this->smarty->assign('email', $admin->getEmail());
        $this->smarty->assign('scheduledEventsNumber', $dashboardData[0]);
        $this->smarty->assign('pendingApplicationsNumber', $dashboardData[1]);
        $this->smarty->assign('usersCount', $dashboardData[2]);
        $this->smarty->display('adminDashboard.tpl');
    }
}

?>