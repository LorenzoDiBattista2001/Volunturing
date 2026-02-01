<?php

class FEvent {

    const VALUES = '(:event_id, :title, :date, :time, :place, :coordinator, :requestedVolunteerNumber, 
                    :maxVolunteerNumber, :fieldOfAction, :candidateRequirements)';
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
                ':candidateRequirements' => $event->getCandidateRequirements());
        
        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);
        return true;
    }

    public static function load(int $eventId) : EEvent {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :eventId';
        $params = array(':eventId' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        $properties = $stmt->fetch(PDO::FETCH_ASSOC);
        $event = new EEvent($properties['title'], $properties['date'] . ' ' . $properties['time'], 
            $properties['place'], $properties['coordinator'], $properties['requestedVolunteerNumber'],
            $properties['maxVolunteerNumber'], EFieldOfAction::from($properties['fieldOfAction']), 
            $properties['candidateRequirements']);
        $event->setEventId($properties['event_id']);
        return $event;
    }

    public static function exist(int $eventId) : bool {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE event_id = :eventId';
        $params = array(':eventId' => $eventId);

        $stmt = FConnectionDB::getInstance()->handleQuery($query, $params);

        if($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    
}

?>