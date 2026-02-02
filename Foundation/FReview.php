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
    
}

?>