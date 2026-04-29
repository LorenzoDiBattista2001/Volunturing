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
        $this->setText($text);
        $this->setRating($rating);
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

    /**
     * Sets the review text written by the user, ensuring
     * it is not null or an empty string
     * 
     * @param string $text The text content of the review
     */
    public function setText(string $text) {
        if(empty($text) || $text === '') {
            throw new Exception('Per pubblicare una recensione, si richiede un commento testuale');
        }
        $this->text = $text;
    }

    public function getText() : string {
        return $this->text;
    }

    /**
     * Sets the review rating choosen by the user, ensuring it
     * is not null and that it is within the allowed range
     * 
     * @param int $rating A 1-to-5 value expressing the user's general opinion about the volunteering association
     */
    public function setRating(int $rating) {
        if(!isset($rating)) {
            throw new Exception('Per pubblicare una recensione, si richiede una valutazione numerica');
        }
        if($rating < 1 || $rating > 5) {
            throw new Exception("La valutazione inserita non è ammessa: si prega di scegliere un valore compreso tra 1 e 5");
        }
        $this->rating = (int) $rating;
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