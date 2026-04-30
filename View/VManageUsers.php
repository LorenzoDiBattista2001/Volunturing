<?php

class VManageUsers {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    /**
     * Displays the list of all registered users (except for admins)
     * 
     * @param array $registeredUsers All the users registered as volunteers
     */
    public function displayRegisteredUsers($registeredUsers) {
        $this->smarty->assign('registeredUsers', $registeredUsers);
        $this->smarty->display('registeredUsers.tpl');
    }

    /**
     * Displays the information associated with a specific user's account
     * 
     * @param \EVolunteer $volunteer The volunteer whose account details are to be displayed
     */
    public function displayUserDetails(EVolunteer $volunteer) {
        $this->smarty->assign('volunteer', $volunteer);
        $this->smarty->display('userDetails.tpl');
    }
}

?>
