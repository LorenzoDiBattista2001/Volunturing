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
        if(CUser::isLogged()) {
            if(UServer::getRequestMethod() === 'POST') {
                $amount = UHTTPMethods::post('amount');
                $reason = UHTTPMethods::post('reason');
                
                USession::getInstance()->setSessionElement('amount', $amount);
                USession::getInstance()->setSessionElement('reason', $reason);

                $view = new VMakeDonation();
                $view->displayPaymentForm($amount);
            } else {
                header('Location: /donation/start');
            }
        } else {
            header('Location: errors/403');
        }
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