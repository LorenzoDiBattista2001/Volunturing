<?php

class FDonation {

    const VALUES = '(:donation_id, :user_id, :amount, :date, :reason)';
    const TABLE = 'donation';

    public static function store(EDonation $donation) : bool {
        $query = 'INSER INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':donation_id' => $donation->getDonationId(),
                    ':user_id' => $donation->getDonator()->getUserId(),
                    ':amount' => $donation->getAmount(),
                    ':date' => $donation->getDate()->format('Y-m-d'),
                    ':reason' => $donation->getReason());
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
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
    
}

?>