<?php

class EReview {

    private int $reviewId;
    private string $text;
    private int $rating;
    private DateTime $date;
    private EVolunteer $author;

    public function __construct(
        string $text,
        int $rating,
        string $date,
        EVolunteer $author)
    {
        $this->text = $text;
        $this->rating = $rating;
        $this->date = new DateTime($date);
        $this->author = $author;
    }
}

?>