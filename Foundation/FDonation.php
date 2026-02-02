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
    
}

?>