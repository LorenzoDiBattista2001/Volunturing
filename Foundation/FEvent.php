<?php

class FEvent {

    const VALUES = '(:event_id, :title, :date, :time, :place, :coordinator, :requestedVolunteerNumber, 
                    :maxVolunteerNumber, :fieldOfAction, :candidateRequirements, :description)';
    const TABLE = 'event';

    /**
     * Stores an event object on the database
     * 
     * @param \EEvent $event The event object to be stored
     * @return bool true on success, false otherwise
     */
    public static function store(EEvent $event) : bool {
        $query = 'INSERT INTO ' . self::TABLE . ' VALUES' . self::VALUES;
        $params = array(':event_id' => null, 
                ':title' => $event->getTitle(), 
                ':date' => $event->getDateAndTime()->format('Y-m-d'), 
                ':time' => $event->getDateAndTime()->format('H:i:s'),
                ':place' => $event->getPlace(), 
                ':coordinator' => $event->getCoordinator(),
                ':requestedVolunteerNumber' => $event->getRequestedVolunteerNumber(), 
                ':maxVolunteerNumber' => $event->getMaxVolunteerNumber(),
                ':fieldOfAction' => $event->getFieldOfAction()->value,
                ':candidateRequirements' => $event->getCandidateRequirements(),
                ':description' => $event->getDescription());
            
        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Fetches an event from the database based on its id
     * 
     * @param int $eventId The id of the event to be fetched
     * @return \EEvent The event object to be instantiated
     */
    public static function load(int $eventId) : EEvent {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $event = new EEvent($properties['title'], $properties['date'] . ' ' . $properties['time'], 
            $properties['place'], $properties['coordinator'], $properties['requestedVolunteerNumber'],
            $properties['maxVolunteerNumber'], $properties['fieldOfAction'], 
            $properties['candidateRequirements'], $properties['description']);
        $event->setEventId($properties['event_id']);
        return $event;
    }

    /**
     * Fetches an event from the database and locks access to its row within a transaction
     * 
     * @param int $eventId The id of the event to be fetched and whose row to lock the access to
     * @return \EEvent The event object to be instantiated
     */
    public static function loadForUpdate(int $eventId) : EEvent {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id FOR UPDATE';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $event = new EEvent($properties['title'], $properties['date'] . ' ' . $properties['time'], 
            $properties['place'], $properties['coordinator'], $properties['requestedVolunteerNumber'],
            $properties['maxVolunteerNumber'], $properties['fieldOfAction'], 
            $properties['candidateRequirements'], $properties['description']);
        $event->setEventId($properties['event_id']);
        return $event;
    }

    /**
     * Retrieves all the events stored on the database
     */
    public static function loadAllEvents() {
        $query = 'SELECT * FROM ' . self::TABLE . ' ORDER BY date ASC';

        $stmt = FConnectionDB::getInstance()->handleQuery($query);

        $events = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EEvent($row['title'], $row['date'] . ' ' . $row['time'],
                $row['place'], $row['coordinator'], $row['requestedVolunteerNumber'],
                $row['maxVolunteerNumber'], $row['fieldOfAction'],
                $row['candidateRequirements'], $row['description']);
            $event->setEventId($row['event_id']);
            $events[] = $event;
        }

        return $events;
    }

    /**
     * Retrieves all the events whose date is greater than a given date
     * 
     * @param string $date The date to be compared with the events dates
     */
    public static function loadEventsByDate(string $date) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE date >= :date ORDER BY date ASC';
        $params = array(':date' => $date);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $events = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new EEvent($row['title'], $row['date'] . ' ' . $row['time'],
                $row['place'], $row['coordinator'], $row['requestedVolunteerNumber'],
                $row['maxVolunteerNumber'], $row['fieldOfAction'],
                $row['candidateRequirements'], $row['description']);
            $event->setEventId($row['event_id']);
            $events[] = $event;
        }

        return $events;
    }

    /**
     * Fetches the total number of scheduled events
     * 
     * @return int The number of scheduled events (i.e. events that do not belong in the past)
     */
    public static function getScheduledEventsNumber() : int {
        $query = 'SELECT COUNT(event_id) FROM ' . self::TABLE . ' WHERE date >= :date';
        $params = array(':date' => date('Y-m-d'));

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
        
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Removes the event with the specified id from the database
     * 
     * @param int $eventId The id of the event to be removed from the database
     * @return bool true on success, false otherwise
     */
    public static function delete(int $eventId) : bool {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Checks whether an event exists based on an id
     * 
     * @param int $eventId The id of the event to check the existence of
     * @return bool true if the event exists, false otherwise
     */
    public static function exist(int $eventId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        return ($stmt->rowCount() > 0);
    }
}

?>