<?php

class CMakeDonation {

    public static function donate() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
            $view = new VMakeDonation();
            $view->displayDonationForm();
        } else {
            header('Location: /errors/loginRequired');
        }
    }

    public static function insertAmount() : void {
        if(CUser::isLogged() && CUser::isVolunteer()) {
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
            header('Location: /errors/403');
        }
    }

    public static function confirmDonation() : void {
        if(CUser::isLogged() && CUser::isVolunteer() && USession::getInstance()->isElementSet('amount') && USession::getInstance()->isElementSet('reason')) {
            if(UServer::getRequestMethod() === 'POST') {
                try {
                    $card = self::createCreditCard();
                    $donation = self::createDonation();
                    if(!$card->performPayment($donation)) {
                        throw new Exception('Al momento non siamo in grado di eseguire la transazione. Ti invitiamo a riprovare più tardi');
                    }
                } catch (Exception $e) {
                    USession::getInstance()->setSessionElement('donationError', $e->getMessage());
                    header('Location: /errors/donation');
                    return;
                }

                if(!FPersistentManager::getInstance()->storeObject($donation)) {
                    header('Location: /errors/500');
                    return;
                }
        
                header('Location: /confirmations/donationPerformed');
            } else {
                header('Location: /donation/amount');
            }
        } else {
            header('Location: /errors/403');
        }
    }

    private static function createCreditCard() : ?ECreditCard {
        $firstName = UHTTPMethods::post('firstName');
        $lastName = UHTTPMethods::post('lastName');
        $number = UHTTPMethods::post('cardNumber');
        $expirationDate = UHTTPMethods::post('expirationDate');
        $cvv = UHTTPMethods::post('cvv');

        return new ECreditCard($firstName, $lastName, $number, $expirationDate, $cvv);
    }

    private static function createDonation() : ?EDonation {
        $amount = USession::getInstance()->getSessionElement('amount');
        $reason = USession::getInstance()->getSessionElement('reason');

        $donation = new EDonation($amount, $reason, date('Y-m-d'));
        $donation->setDonator(FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user')));

        return $donation;
    }

}

?>