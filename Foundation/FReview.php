<?php

class FReview {

    const VALUES = '(:review_id, :user_id, :text, :rating, :date)';
    const TABLE = 'review';

    public static function store(EReview $review) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':review_id' => $review->getReviewId(),
                ':user_id' => $review->getAuthor()->getUserId(),
                ':text' => $review->getText(),
                ':rating' => $review->getRating(),
                ':date' => $review->getDate()->format('Y-m-d'));
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
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
    
}

?>