<?php

class FUser {

    const VALUES = '(:user_id, :firstName, :lastName, :email, :password, :birthDate, :birthPlace, 
                    :taxCode, :telephoneNumber, :streetAddress, :houseNumber, :description,
                    :isBlocked, :isAdmin)';
    const TABLE = 'user';
    
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