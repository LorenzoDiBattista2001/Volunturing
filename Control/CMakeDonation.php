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

    public static function confirmDonation() : void {
        if(CUser::isLogged()) {
            if(UServer::getRequestMethod() === 'POST') {
                $card = self::createCreditCard();
                if($card === null) {
                    header('Location: /errors/invalidCardData');
                    return;
                }

                if(USession::getInstance()->isElementSet('amount') && USession::getInstance()->isElementSet('reason')) {
                    $donation = self::createDonation();
                    if($donation === null) {
                        header('Location: /errors/invalidDonationAmount');
                        return;
                    }
                } else {
                    header('Location: /');
                }

                if($card->performPayment($donation)) {
                    if(FPersistentManager::getInstance()->storeObject($donation)) {
                        header('Location: /confirmations/donationPerformed');
                    } else {
                        header('Location: /errors/500');
                    }
                } else {
                    header('Location: /errors/transactionFailed');
                }
            } else {
                header('Location: /donation/amount');
            }
        } else {
            header('Location: /');
        }
    }

    private static function createCreditCard() : ?ECreditCard {
        $firstName = UHTTPMethods::post('firstName');
        $lastName = UHTTPMethods::post('lastName');
        $number = UHTTPMethods::post('cardNumber');
        $expirationDate = UHTTPMethods::post('expirationDate');
        $cvv = UHTTPMethods::post('cvv');

        try {
            $card = new ECreditCard($firstName, $lastName, $number, $expirationDate, $cvv);
        } catch (Exception $e) {
            USession::getInstance()->setSessionElement('creditCardError', $e->getMessage());
            return null;
        }
        return $card;
    }

    private static function createDonation() : ?EDonation {
        $amount = USession::getInstance()->getSessionElement('amount');
        $reason = USession::getInstance()->getSessionElement('reason');

        try {
            $donation = new EDonation($amount, $reason, date('Y-m-d'));
            $donation->setDonator(FPersistentManager::getInstance()->loadUserById(USession::getInstance()->getSessionElement('user')));
        } catch (Exception $e) {
            USession::getInstance()->setSessionElement('donationError', $e->getMessage());
            return null;
        }
        return $donation;
    }

}

?>