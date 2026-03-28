<?php

class CMakeDonation {

    public static function donate() : void {
        if(CUser::isLogged()) {
            $view = new VMakeDonation();
            $view->displayDonationForm();
        } else {
            // tell the user that they have to log in in order to donate
        }
    }

    public static function insertAmount() : void {
        // show credit card form
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
            // show confirmation message
        } else {
            // show error message
        }

    }

}

?>