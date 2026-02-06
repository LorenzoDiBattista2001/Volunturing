<?php

class FApplication {
    
    const VALUES = '(:user_id, :event_id, :submittedDate, :submittedTime, :state, :message, 
                    :reasonForRejection, :wasAccepted)';
    const TABLE = 'application';

    public static function store(EApplication $application) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':user_id' => $application->getUserId(),
                    ':event_id' => $application->getEventId(),
                    ':submittedDate' => $application->getSubmittedDateTime()->format('Y-m-d'),
                    ':submittedTime' => $application->getSubmittedDateTime()->format('H:i:s'),
                    ':state' => $application->getState()->value,
                    ':message' => $application->getMessage(),
                    ':reasonForRejection' => $application->getReasonForRejection(),
                    ':wasAccepted' => $application->wasAccepted());
                    
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

    public static function loadByEvent(int $eventId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $applications = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $application = new EApplication($row['submittedDate'] . ' ' . $row['submittedTime'],
                EApplicationState::from($row['state']), $row['message']);
            $application->setUserId($row['user_id']);
            $application->setEventId($row['event_id']);
            $applications[] = $application;
        }

        return $applications;
    }

    public static function loadByUser(int $userId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $applications = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $application = new EApplication($row['submittedDate'] . ' ' . $row['submittedTime'],
                EApplicationState::from($row['state']), $row['message']);
            $application->setUserId($row['user_id']);
            $application->setEventId($row['event_id']);
            $applications[] = $application;
        }

        return $applications;
    }

    public static function exist(int $userId, int $eventId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id AND event_id = :event_id';
        $params = array(':user_id' => $userId, ':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

}

?>