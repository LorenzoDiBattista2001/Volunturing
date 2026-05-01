<?php

class FDonation {

    const VALUES = '(:donation_id, :user_id, :amount, :date, :reason)';
    const TABLE = 'donation';

    /**
     * Stores a donation object on the database
     * 
     * @param \EDonation $donation The donation object to be stored
     * @return bool true on success, false otherwise
     */
    public static function store(EDonation $donation) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':donation_id' => null,
                    ':user_id' => $donation->getDonator()->getUserId(),
                    ':amount' => $donation->getAmount(),
                    ':date' => $donation->getDate()->format('Y-m-d'),
                    ':reason' => $donation->getReason());
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieves a donation object based on its id
     * 
     * @param int $donationId The id of the donation to be fetched
     * @return \EDonation The donation object to be instantiated
     */
    public static function load(int $donationId) : EDonation {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE donation_id = :donation_id';
        $params = array(':donation_id' => $donationId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $donation = new EDonation($properties['amount'], $properties['reason'], $properties['date']);
        $donation->setDonationId($properties['donation_id']);
        $donation->setUserId($properties['user_id']);

        return $donation;
    }

    /**
     * Retrieves all the donations made by a given user
     * 
     * @param int $userId The id of the user who made the donations
     */
    public static function loadByUser(int $userId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $donations = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $donation = new EDonation($row['amount'], $row['reason'], $row['date']);
            $donation->setDonationId($row['donation_id']);
            $donation->setUserId($row['user_id']);
            $donations[] = $donation;
        }

        return $donations;
    }

    /**
     * Checks whether a donation exists based on an id
     * 
     * @param int $donationId The id of the donation to check the existence of
     * @return bool true if the donation exists, false otherwise
     */
    public static function exist(int $donationId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE donation_id = :donation_id';
        $params = array(':donation_id' => $donationId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }
}

?>