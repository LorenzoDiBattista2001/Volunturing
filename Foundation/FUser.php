<?php

class FUser {

    const VALUES = '(:user_id, :firstName, :lastName, :email, :password, :birthDate, :birthPlace, 
                    :taxCode, :telephoneNumber, :streetAddress, :houseNumber, :description,
                    :isBlocked, :isAdmin)';
    const TABLE = 'user';
    
    /**
     * Identifies the type of user to be stored and calls the relevant private method
     * 
     * @param \EUser $user The user object to be stored on the database
     * @return bool true on success, false otherwise
     */
    public static function store(EUser $user) : bool {
        $class = get_class($user);
        if ($class === 'EVolunteer') {
            return self::storeVolunteer($user);
        } else if ($class === 'EAdmin') {
            return self::storeAdmin($user);
        }
    }

    /**
     * Stores a volunteer object on the database
     * 
     * @param \EVolunteer $volunteer The volunteer object to be stored on the database
     * @return bool true on success, false otherwise
     */
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
                ':isBlocked' => (int) $volunteer->isBlocked(),
                ':isAdmin' => 0);
        
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            $volunteer->setUserId(FConnectionDB::getInstance()->getLastInsertId());
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Stores an admin object on the database
     * 
     * @param \EAdmin $admin The admin object to be stored on the database
     * @return bool true on success, false otherwise
     */
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
                ':isAdmin' => 1);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Updates a volunteer's password on the database
     * 
     * @param int $userId The id of the volunteer whose password is to be updated
     * @param string $password The hashed string of the new password
     * @return bool true on success, false otherwise
     */
    public static function updatePassword(int $userId, string $password) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET password = :password WHERE user_id = :user_id';
        $params = array(':user_id' => $userId, ':password' => $password);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Updates a volunteer's email on the database
     * 
     * @param int $userId The id of the volunteer whose email is to be updated
     * @param string $password The new email
     * @return bool true on success, false otherwise
     */
    public static function updateEmail(int $userId, string $email) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET email = :email WHERE user_id = :user_id';
        $params = array(':user_id' => $userId, ':email' => $email);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Updates a volunteer's account information
     * 
     * @param \EVolunteer $volunteer The volunteer whose account information is to be updated
     * @return bool true on success, false otherwise
     */
    public static function updateProfile(EVolunteer $volunteer) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET telephoneNumber = :telephoneNumber, streetAddress = :streetAddress,
                    houseNumber = :houseNumber, description = :description WHERE user_id = :user_id';
        $params = array(':user_id' => $volunteer->getUserId(), ':telephoneNumber' => $volunteer->getTelephoneNumber(),
                        ':streetAddress' => $volunteer->getStreetAddress(), ':houseNumber' => $volunteer->getHouseNumber(),
                        ':description' => $volunteer->getDescription());

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Updates the state of a volunteer's profile
     * 
     * @param \EVolunteer $volunteer The volunteer whose state is to be updated
     * @return bool true on success, false otherwise
     */
    public static function updateVolunteerState(EVolunteer $volunteer) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET isBlocked = :isBlocked WHERE user_id = :user_id';
        $params = array(':user_id' => $volunteer->getUserId(), ':isBlocked' => (int) $volunteer->isBlocked());

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Fetches a user based on their database id and instantiates it
     * 
     * @param int $userId The id of the user to be fetched
     * @return \EUser The user object to be instantiated
     */
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

    /**
     * Fetches a user based on their email address and instantiates it
     * 
     * @param string $email The email address of the user to be fetched
     * @return \EUser The user object to be instantiated
     */
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

    /**
     * Fetches all volunteer users
     * 
     * @return array Volunteer objects
     */
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

    /**
     * Fetches the number of volunteer users
     * 
     * @return int The total number of volunteer registered users
     */
    public static function getVolunteersCount() : int {
        $query = 'SELECT COUNT(*) FROM ' . self::TABLE . ' WHERE isAdmin = :isAdmin';
        $params = array(':isAdmin' => false);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Checks whether a user exists with a given id
     * 
     * @param int $userId The id of the user to check the existence of
     * @return bool true if the user exists, false otherwise
     */
    public static function exist(int $userId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }

    /**
     * Checks whether a given email address belongs to a registered user
     * 
     * @param string $email The email address to check the existence of
     * @return bool true if the email address belongs to a registered user, false otherwise
     */
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