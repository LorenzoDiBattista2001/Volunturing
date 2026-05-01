<?php

class VUser {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the web application's general home page
     */
    public function displayHomePage() {
        $this->smarty->display('home.tpl');
    }

    /**
     * Displays the form for logging in
     */
    public function displayLoginForm() {
        $this->smarty->display('loginForm.tpl');
    }

    /**
     * Displays the form for registering as a volunteer
     */
    public function displayRegistrationForm() {
        $this->smarty->display('registrationForm.tpl');
    }

    /**
     * Displays a volunteer's personal area
     * 
     * @param \EVolunteer $volunteer The volunteer user whose personal area is to be displayed
     */
    public function displayVolunteerPersonalArea(EVolunteer $volunteer) {
        $this->smarty->assign('volunteer', $volunteer);
        $this->smarty->assign('applications', $volunteer->getApplications());
        $this->smarty->assign('donations', $volunteer->getDonations());
        $this->smarty->assign('reviews', $volunteer->getReviews());
        $this->smarty->display('volunteerPersonalArea.tpl');
    }

    /**
     * Displays the page for updating a user's profile information
     * @param \EVolunteer $volunteer The volunteer user whose profile update page is to be displayed
     */
    public function displayVolunteerAccountManagement(EVolunteer $volunteer) {
        $this->smarty->assign('user', $volunteer);
        $this->smarty->display('updateProfile.tpl');
    }

    /**
     * Displays the admin's dashboard with statistics
     * 
     * @param \EAdmin $admin The admin user whose dashboard is to be displayed
     * @param array $dashboardData Statistics for the admin
     */
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