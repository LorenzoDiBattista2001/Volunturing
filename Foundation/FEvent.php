<?php

class FEvent {

    const VALUES = '(:event_id, :title, :date, :time, :place, :coordinator, :requestedVolunteerNumber, 
                    :maxVolunteerNumber, :fieldOfAction, :candidateRequirements, :description)';
    const TABLE = 'event';

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
            print("STORE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

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

    public static function loadEventsByDate(string $date) {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE date >= :date ORDER BY date ASC';
        $params = array(':date' => $date);

        $stm = FConnectionDB::getInstance()->handleQuery($query, $params);

        $events = array();
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $event = new EEvent($row['title'], $row['date'] . ' ' . $row['time'],
                $row['place'], $row['coordinator'], $row['requestedVolunteerNumber'],
                $row['maxVolunteerNumber'], $row['fieldOfAction'],
                $row['candidateRequirements'], $row['description']);
            $event->setEventId($row['event_id']);
            $events[] = $event;
        }

        return $events;
    }

    public static function delete(int $eventId) : bool {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        try {
            $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
            return true;
        } catch (Exception $e) {
            print("DELETE OPERATION FAILED: " . $e->getMessage());
            return false;
        }
    }

    public static function exist(int $eventId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :event_id';
        $params = array(':event_id' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
}

?>