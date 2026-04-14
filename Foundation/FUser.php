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
            $volunteer->setUserId(FConnectionDB::getInstance()->getLastInsertId());
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

    public static function updatePassword(int $userId, string $password) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET password = :password WHERE user_id = :user_id';
        $params = array(':user_id' => $userId, ':password' => $password);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("UPDATE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

    public static function updateEmail(int $userId, string $email) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET email = :email WHERE user_id = :user_id';
        $params = array(':user_id' => $userId, ':email' => $email);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("UPDATE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

    public static function updateVolunteerState(EVolunteer $volunteer) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET isBlocked = :isBlocked WHERE user_id = :user_id';
        $params = array(':user_id' => $volunteer->getUserId(), ':isBlocked' => $volunteer->isBlocked());

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public static function loadById(int $userId) : EUser {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

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
            $volunteer->setDescription($properties['description']);
            $volunteer->setHashedPassword($properties['password']);
            $volunteer->setUserId($properties['user_id']);
            return $volunteer;
        } else {
            $admin = new EAdmin(
                $properties['firstName'],
                $properties['lastName'],
                $properties['email'],
                $properties['password']
            );
            $admin->setHashedPassword($properties['password']);
            $admin->setUserId($properties['user_id']);
            return $admin;
        }

    }

    public static function loadByEmail(string $email) : EUser {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE email = :email';
        $params = array(':email' => $email);

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
            $volunteer->setDescription($properties['description']);
            $volunteer->setHashedPassword($properties['password']);
            $volunteer->setUserId($properties['user_id']);
            return $volunteer;
        } else {
            $admin = new EAdmin(
                $properties['firstName'],
                $properties['lastName'],
                $properties['email'],
                $properties['password']
            );
            $admin->setHashedPassword($properties['password']);
            $admin->setUserId($properties['user_id']);
            return $admin;
        }

    }

    public static function loadAllVolunteers() {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE isAdmin = :isAdmin';
        $params = array(':isAdmin' => false);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $volunteers = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $volunteer = new EVolunteer($row['firstName'], $row['lastName'],
                $row['email'],
                $row['password'],
                $row['birthDate'],
                $row['birthPlace'],
                $row['taxCode'],
                $row['telephoneNumber'],
                $row['streetAddress'],
                $row['houseNumber'],
                $row['isBlocked']);
            $volunteer->setDescription($row['description']);
            $volunteer->setHashedPassword($row['password']);
            $volunteer->setUserId($row['user_id']);
            $volunteers[] = $volunteer;
        }

        return $volunteers;
    }

    public static function getVolunteersCount() : int {
        $query = 'SELECT COUNT(*) FROM ' . self::TABLE . ' WHERE isAdmin = :isAdmin';
        $params = array(':isAdmin' => false);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public static function exist(int $userId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public static function emailExist(string $email) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE email = :email';
        $params = array(':email' => $email);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }

    public static function newEmailExist(string $email, int $userId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE email = :email AND user_id <> :user_id';
        $params = array(':email' => $email, ':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }
}

?>