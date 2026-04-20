<?php

class FReview {

    const VALUES = '(:review_id, :user_id, :text, :rating, :date)';
    const TABLE = 'review';

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

    public static function exist(int $reviewId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE review_id = :review_id';
        $params = array(':review_id' => $reviewId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }

    public static function getAverageRating() : int {
        $query = 'SELECT AVG(rating) FROM ' . self::TABLE;

        $stmt = FConnectionDB::getInstance()->handleQuery($query);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public static function getReviewsNumber() : int {
        $query = 'SELECT COUNT(review_id) FROM ' . self::TABLE;

        $stmt = FConnectionDB::getInstance()->handleQuery($query);
        
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
    
}

?>