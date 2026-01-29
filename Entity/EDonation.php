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
}

?>