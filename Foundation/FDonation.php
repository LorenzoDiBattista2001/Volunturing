<?php

class FDonation {

    const VALUES = '(:donation_id, :user_id, :amount, :date, :reason)';
    const TABLE = 'donation';

    public static function store(EDonation $donation) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':donation_id' => $donation->getDonationId(),
                    ':user_id' => $donation->getDonator()->getUserId(),
                    ':amount' => $donation->getAmount(),
                    ':date' => $donation->getDate()->format('Y-m-d'),
                    ':reason' => $donation->getReason());
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

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

    public static function exist(int $donationId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE donation_id = :donation_id';
        $params = array(':donation_id' => $donationId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
}

?>