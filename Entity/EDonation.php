<?php

class EDonation {

    private int $donationId;
    private int $amount;
    private ?string $reason;
    private DateTime $date;
    private EVolunteer $donator;

    public function __construct(
        int $amount,
        ?string $reason,
        string $date,
        EVolunteer $donator)
    {
        $this->amount = $amount;
        $this->reason = $reason;
        $this->date = new DateTime($date);
        $this->donator = $donator;
    }

    // 'set' and 'get' methods

    public function setDonationId(int $donationId) {
        $this->donationId = $donationId;
    }

    public function getDonationId() : int {
        return $this->donationId;
    }

    public function setAmount(int $amount) {
        if ($amount < 10) {
            throw new Exception('Amount is too small');
        } else {
            $this->amount = $amount;
        }
    }

    public function getAmount() : int {
        return $this->amount;
    }

    public function setReason(?string $reason) {
        $this->reason = $reason;
    }

    public function getReason() : ?string {
        return $this->reason;
    } 

    public function setDate(string $date) {
        $this->date = new DateTime($date);
    }

    public function getDate() : DateTime {
        return $this->date;
    }

    public function setDonator(EVolunteer $donator) {
        $this->donator = $donator;
    }

    public function getDonator() : EVolunteer {
        return $this->donator;
    }
}

?>