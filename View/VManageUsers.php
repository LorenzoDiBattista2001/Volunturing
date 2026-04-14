<?php

class VManageUsers {

    private $smarty;

    public function __construct() {
        $this->smarty = VStartSmarty::configuration();
    }

    public function displayRegisteredUsers($registeredUsers) {
        $this->smarty->assign('registeredUsers', $registeredUsers);
        $this->smarty->display('registeredUsers.tpl');
    }

    public function displayUserDetails(EVolunteer $volunteer) {
        $this->smarty->assign('volunteer', $volunteer);
        $this->smarty->display('userDetails.tpl');
    }
}

?>
