<?php

 class CManageUsers {

    public static function accessUserManagement() : void {
      // check if user is logged in
      // check if user is admin
      // display users list

    }

    public static function selectUser(int $userId) : void {

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