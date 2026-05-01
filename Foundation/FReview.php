<?php

class FReview {

    const VALUES = '(:review_id, :user_id, :text, :rating, :date)';
    const TABLE = 'review';

    /**
     * Stores a review object on the database
     * 
     * @param \EReview $review The review object to be stored
     * @return bool true on success, false otherwise
     */
    public static function store(EReview $review) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':review_id' => null,
                ':user_id' => $review->getUserId(),
                ':text' => $review->getText(),
                ':rating' => $review->getRating(),
                ':date' => $review->getDate()->format('Y-m-d'));
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieves a review object based on its id
     * 
     * @param int $reviewId The id of the review to be fetched
     * @return \EReview The review object to be instantiated
     */
    public static function load(int $reviewId) : EReview {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE review_id = :review_id';
        $params = array(':review_id' => $reviewId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $review = new EReview($properties['text'], $properties['rating'], $properties['date']);
        $review->setReviewId($properties['review_id']);
        $review->setUserId($properties['user_id']);

        return $review;
    }

    /**
     * Retrieves all the reviews stored on the database
     */
    public static function loadAllReviews() {
        $query = 'SELECT * FROM ' . self::TABLE . ' ORDER BY date ASC';

        $stmt = FConnectionDB::getInstance()->handleQuery($query);

        $reviews = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $review = new EReview($row['text'], $row['rating'], $row['date']);
            $review->setReviewId($row['review_id']);
            $review->setUserId($row['user_id']);
            $reviews[] = $review;
        }

        return $reviews;
    }

    /**
     * Retrieves all the reviews written by a given user
     * 
     * @param int $userId The id of the user who wrote the reviews
     */
    public static function loadByUser(int $userId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $reviews = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $review = new EReview($row['text'], $row['rating'], $row['date']);
            $review->setReviewId($row['review_id']);
            $review->setUserId($row['user_id']);
            $reviews[] = $review;
        }

        return $reviews;
    }

    /**
     * Removes the review with the specified id from the database
     * 
     * @param int $reviewId The id of the review to be removed from the database
     * @return bool true on success, false otherwise
     */
    public static function delete(int $reviewId) : bool {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE review_id = :review_id';
        $params = array(':review_id' => $reviewId);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Checks whether a review exists based on an id
     * 
     * @param int $reviewId The id of the review to check the existence of
     * @return bool true if the review exists, false otherwise
     */
    public static function exist(int $reviewId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE review_id = :review_id';
        $params = array(':review_id' => $reviewId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }

    /**
     * Fetches the mean of the ratings of all the reviews stored on the database
     * 
     * @return int The average rating expressed by the volunteers
     */
    public static function getAverageRating() : int {
        $query = 'SELECT AVG(rating) FROM ' . self::TABLE;

        $stmt = FConnectionDB::getInstance()->handleQuery($query);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Fetches the number of reviews stored on the database
     * 
     * @return int The total number of reviews stored on the database
     */
    public static function getReviewsNumber() : int {
        $query = 'SELECT COUNT(review_id) FROM ' . self::TABLE;

        $stmt = FConnectionDB::getInstance()->handleQuery($query);
        
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}

?>