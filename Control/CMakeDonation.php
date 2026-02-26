<?php

class CMakeDonation {

    private static int $tempAmount;
    private static string $tempReason;
    private static int $tempUserId;

    public static function donate() : void {
        print('Inserire un importo: ' . "\n");
        print('Inserire una causale (opzionale): ' . "\n");
    }

    public static function insertAmount(int $amount, string $message, int $userId) : void {
        self::$tempAmount = $amount;
        self::$tempReason = $message;
        self::$tempUserId = $userId;
        print('Inserire i dati della carta di credito: ' . "\n");
    }

    public static function confirmDonation(string $firstName, string $lastName,
                            string $number, string $expirationDate, string $cvv) : bool 
    {
        try {
            $card = new ECreditCard($firstName, $lastName, $number, $expirationDate, $cvv);
        } catch (Exception $e) {
            print($e->getMessage());
            exit();
        }
        $donation = new EDonation(self::$tempAmount, self::$tempReason, date('Y-m-d'));
        $donation->setDonator(FPersistentManager::getInstance()->loadUserById(self::$tempUserId));
        $paymentCompleted = $card->performPayment($donation);
        if($paymentCompleted) {
            return FPersistentManager::getInstance()->storeObject($donation);
        } else {
            print('ERROR: payment process failed');
        }

    }

}

?>