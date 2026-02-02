<?php

class FUser {

    const VALUES = '(:user_id, :firstName, :lastName, :email, :password, :birthDate, :birthPlace, 
                    :taxCode, :telephoneNumber, :streetAddress, :houseNumber, :description,
                    :isBlocked, :isAdmin)';
    const TABLE = 'user';
    
    public static function store(EUser $user) : bool {
        $class = get_class($user);
        if ($class === 'EVolunteer') {
            return self::storeVolunteer($user);
        } else if ($class === 'EAdmin') {
            return self::storeAdmin($user);
        }
    }

    private static function storeVolunteer(EVolunteer $volunteer) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':user_id' => null,
                ':firstName' => $volunteer->getFirstName(),
                ':lastName' => $volunteer->getLastName(),
                ':email' => $volunteer->getEmail(),
                ':password' => $volunteer->getPassword(),
                ':birthDate' => $volunteer->getBirthDate()->format('Y-m-d'),
                ':birthPlace' => $volunteer->getBirthPlace(),
                ':taxCode' => $volunteer->getTaxCode(),
                ':telephoneNumber' => $volunteer->getTelephoneNumber(),
                ':streetAddress' => $volunteer->getStreetAddress(),
                ':houseNumber' => $volunteer->getHouseNumber(),
                ':description' => $volunteer->getDescription(),
                ':isBlocked' => $volunteer->isBlocked(),
                ':isAdmin' => false);
        
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

    private static function storeAdmin(EAdmin $admin) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':user_id' => null,
                ':firstName' => $admin->getFirstName(),
                ':lastName' => $admin->getLastName(),
                ':email' => $admin->getEmail(),
                ':password' => $admin->getPassword(),
                ':birthDate' => null,
                ':birthPlace' => null,
                ':taxCode' => null,
                ':telephoneNumber' => null,
                ':streetAddress' => null,
                ':houseNumber' => null,
                ':description' => null,
                ':isBlocked' => null,
                ':isAdmin' => true);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }
    
    
    public static function loadById(int $userId) : EUser {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :userId';
        $params = array(':userId' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
        $properties = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$properties['isAdmin']) {
            $volunteer = new EVolunteer(
                $properties['firstName'],
                $properties['lastName'],
                $properties['email'],
                $properties['password'],
                $properties['birthDate'],
                $properties['birthPlace'],
                $properties['taxCode'],
                $properties['telephoneNumber'],
                $properties['streetAddress'],
                $properties['houseNumber'],
                $properties['isBlocked']
            );
            $volunteer->setUserId($properties['user_id']);
            return $volunteer;
        } else {
            $admin = new EAdmin(
                $properties['firstName'],
                $properties['lastName'],
                $properties['email'],
                $properties['password']
            );
            $admin->setUserId($properties['user_id']);
            return $admin;
        }

    }
}

?>