<?php

class EReview {

    private int $reviewId;
    private int $userId;
    private string $text;
    private int $rating;
    private DateTime $date;
    private EVolunteer $author;

    public function __construct(
        string $text,
        int $rating,
        string $date)
    {
        $this->text = $text;
        $this->rating = $rating;
        $this->date = new DateTime($date);
    }

    // 'set' and 'get' methods

    public function setReviewId(int $reviewId) {
        $this->reviewId = $reviewId;
    }

    public function getReviewId() : int {
        return $this->reviewId;
    }

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getUserId() : int {
        return $this->userId;
    }

    public function setText(string $text) {
        $this->text = $text;
    }

    public function getText() : string {
        return $this->text;
    }

    public function setRating(int $rating) {
        if($rating < 1 || $rating > 5) {
            throw new Exception("Illegal rating value");
        } else {
            $this->rating = $rating;
        }
    }

    public function getRating() : int {
        return $this->rating;
    }

    public function setDate(string $date) {
        $this->date = new DateTime($date);
    }

    public function getDate() : DateTime {
        return $this->date;
    }

    public function setAuthor(EVolunteer $author) {
        $this->author = $author;
    }

    public function getAuthor() : EVolunteer {
        return $this->author;
    }
}

?>