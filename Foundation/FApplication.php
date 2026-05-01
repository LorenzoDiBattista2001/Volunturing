<?php

class FApplication {
    
    const VALUES = '(:user_id, :event_id, :submittedDate, :submittedTime, :state, :message, 
                    :reasonForRejection, :wasAccepted)';
    const TABLE = 'application';

    /**
     * Stores an application object on the database
     * 
     * @param \EApplication $application The application object to be stored
     * @return bool true on success, false otherwise
     */
    public static function store(EApplication $application) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':user_id' => $application->getUserId(),
                    ':event_id' => $application->getEventId(),
                    ':submittedDate' => $application->getSubmittedDateTime()->format('Y-m-d'),
                    ':submittedTime' => $application->getSubmittedDateTime()->format('H:i:s'),
                    ':state' => $application->getState()->value,
                    ':message' => $application->getMessage(),
                    ':reasonForRejection' => $application->getReasonForRejection(),
                    ':wasAccepted' => (int) $application->wasAccepted());
                    
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Fetches an application based on the IDs of its candidate and of the event it was submitted for
     * 
     * @param int $userId The id of the candidate the application belongs to
     * @param int $eventId The id of the event the application was submitted for
     * @return \EApplication The application object to be instantiated
     */
    public static function load(int $userId, int $eventId) : EApplication {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id AND event_id = :event_id';
        $params = array(':user_id' => $userId, ':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $application = new EApplication($properties['submittedDate'] . ' ' . $properties['submittedTime'],
            EApplicationState::from($properties['state']), $properties['message']);
        if($properties['wasAccepted']) {
            $application->markAsAccepted();
        }
        $application->setReasonForRejection($properties['reasonForRejection']);
        $application->setUserId($properties['user_id']);
        $application->setEventId($properties['event_id']);

        return $application;
    }

    /**
     * Retrieves an array of application objects based on the id of the event they were submitted for
     * 
     * @param int $eventId The id of the event which the applications were submitted for
     */
    public static function loadByEvent(int $eventId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id ORDER BY submittedDate ASC, submittedTime ASC';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $applications = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $application = new EApplication($row['submittedDate'] . ' ' . $row['submittedTime'],
                EApplicationState::from($row['state']), $row['message']);
            if($row['wasAccepted']) {
                $application->markAsAccepted();
            }
            $application->setUserId($row['user_id']);
            $application->setEventId($row['event_id']);
            $applications[] = $application;
        }

        return $applications;
    }

    /**
     * Retrieves an array of application objects based on the id of the candidate
     * 
     * @param int $userId The id of the user who submitted the applications
     */
    public static function loadByUser(int $userId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id';
        $params = array(':user_id' => $userId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $applications = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $application = new EApplication($row['submittedDate'] . ' ' . $row['submittedTime'],
                EApplicationState::from($row['state']), $row['message']);
            if($row['wasAccepted']) {
                $application->markAsAccepted();
            }
            $application->setUserId($row['user_id']);
            $application->setEventId($row['event_id']);
            $applications[] = $application;
        }

        return $applications;
    }

    /**
     * Fetches the number of all pending applications, regardless of the event they have been submitted for
     * 
     * @return int The total number of pending applications stored on the database
     */
    public static function getPendingApplicationsNumber() : int {
        $query = 'SELECT COUNT(*) FROM ' . self::TABLE . ' WHERE state = :state';
        $params = array(':state' => EApplicationState::WAITING->value);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Updates an application object on the database
     * 
     * @param \EApplication $application The application object to be updated
     * @return bool true on success, false otherwise
     */
    public static function update(EApplication $application) : bool {
        $query = 'UPDATE ' . self::TABLE . ' SET state = :state, reasonForRejection = :reasonForRejection,
                            wasAccepted = :wasAccepted WHERE user_id = :user_id AND event_id = :event_id';
        $params = array(':state' => $application->getState()->value, 
                        ':reasonForRejection' => $application->getReasonForRejection(),
                        ':wasAccepted' => (int) $application->wasAccepted(),
                        ':user_id' => $application->getUserId(),
                        ':event_id' => $application->getEventId());

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Checks whether an application exists based on the IDs of a user and of an event
     * 
     * @param int $userId The id of the user whose application to check the existence of
     * @param int $eventId The id of the event which the application whose existence is to be checked belongs to
     * @return bool true if the application exists, false otherwise
     */
    public static function exist(int $userId, int $eventId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id = :user_id AND event_id = :event_id';
        $params = array(':user_id' => $userId, ':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }
}

?>