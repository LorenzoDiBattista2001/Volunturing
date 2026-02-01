<?php

class FApplication {
    
    const VALUES = '(:user_id, :event_id, :submittedDate, :submittedTime, :state, :message, 
                    :reasonForRejection, :wasAccepted)';
    const TABLE = 'application';

    public static function loadByEvent(int $eventId) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :eventId';
        $params = array(':eventId' => $eventId);

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

}

?>