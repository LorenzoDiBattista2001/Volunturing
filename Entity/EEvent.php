<?php

class EEvent {
    
    private int $eventId;
    private string $title;
    private DateTime $dateAndTime;
    private string $place;
    private string $coordinator;
    private int $requestedVolunteerNumber;
    private int $maxVolunteerNumber;
    private EFieldOfAction $fieldOfAction;
    private ?string $candidateRequirements;
    private array $applications;

    public function __construct(
        string $title,
        string $dateAndTime,
        string $place,
        string $coordinator,
        int $requestedVolunteerNumber,
        int $maxVolunteerNumber,
        EFieldOfAction $fieldOfAction,
        ?string $candidateRequirements) 
    {
        $this->title = $title;
        $this->dateAndTime = new DateTime($dateAndTime);
        $this->place = $place;
        $this->coordinator = $coordinator;
        $this->requestedVolunteerNumber = $requestedVolunteerNumber;
        $this->maxVolunteerNumber = $maxVolunteerNumber;
        $this->fieldOfAction = $fieldOfAction;
        $this->candidateRequirements = $candidateRequirements;
        $this->applications = array();
    }
}

?>