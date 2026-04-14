<?php

 class CManageUsers {

    public static function accessUserManagement() : void {
      if(CUser::isLogged() && CUser::isAdmin()) {
        $view = new VManageUsers();
        $registeredUsers = FPersistentManager::getInstance()->retrieveRegisteredUsers();
        $view->displayRegisteredUsers($registeredUsers);
      } else {
        header('Location: /errors/403');
      }

    }

    public static function selectUser(int $userId) : void {
      if(CUser::isLogged() && CUser::isAdmin()) {
        $view = new VManageUsers();
        $volunteer = FPersistentManager::getInstance()->loadUserById($userId);
        if(!($volunteer::class === 'EVolunteer')) {
          header('Location: /errors/403');
          return;
        }
        $view->displayUserDetails($volunteer);
      }
    }

    public static function blockUser(int $userId) : void {
      

    }

    public static function performUserBlocking(int $userId, string $reason) : void {
      $pm = FPersistentManager::getInstance();
      $volunteer = $pm->loadUserById($userId);
      // check if user is an instance of EVolunteer
      $volunteer->block();
      // update volunteer on database
    }

    public static function unlockUser(int $userId) : void {

    }
 }
?>