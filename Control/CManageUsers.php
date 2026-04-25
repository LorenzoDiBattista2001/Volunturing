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
      if(CUser::isLogged() && CUser::isAdmin()) {
        if(UServer::getRequestMethod() === 'POST') {
          $pm = FPersistentManager::getInstance();
          $volunteer = $pm->loadUserById($userId);
          
          try {
            if(!($volunteer::class === 'EVolunteer')) {
              throw new Exception('Only users of type \'volunteer\' may be blocked');
            }

            $reason = UHTTPMethods::post('reason');
            if(!isset($reason) || $reason === '') {
              throw new Exception('Reason is required when blocking a user');
            }

            $volunteer->block();

            if(!$pm->updateVolunteerState($volunteer)) {
              header('Location: /errors/500');
              return;
            }

            $view = new VEmail();
            $subject = 'Volontorino OdV - Avviso Blocco Profilo';
            $body = $view->generateUserBlockingEmail($reason);
            if(!UEmail::sendEmail($volunteer->getEmail(), $volunteer->getFirstName(), $subject, $body)) {
              throw new Exception('Failed to send notification email to blocked user: ' . $volunteer->getEmail());
            }

            header('Location: /admin/confirmations/userBlocked');
            return;
          } catch (Exception $e) {
            USession::getInstance()->setSessionElement('userBlockingError', $e->getMessage());
            header('Location: /admin/errors/userBlocking');
            return;
          }
        } else {
          header('Location: /admin/users/select/' . $userId);
        }
      } else {
        header('Location: /errors/403');
      }
    }

    public static function unlockUser(int $userId) : void {
      if(CUser::isLogged() && CUser::isAdmin()) {
        $pm = FPersistentManager::getInstance();
        $volunteer = $pm->loadUserById($userId);

        try {
          if(!($volunteer::class === 'EVolunteer')) {
            throw new Exception('Only users of type \'volunteer\' may be unlocked');
          }

          $volunteer->unlock();

          if(!$pm->updateVolunteerState($volunteer)) {
            header('Location: /errors/500');
            return;
          }

          header('Location: /admin/confirmations/userUnlocked');
          return;
        } catch (Exception $e) {
          USession::getInstance()->setSessionElement('userUnlockingError', $e->getMessage());
          header('Location: /admin/errors/userUnlocking');
          return;
        }
      } else {
        header('Location: /errors/403');
      }
    }
 }
?>