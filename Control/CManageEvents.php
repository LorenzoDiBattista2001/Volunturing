<?php

class CManageEvents {

    public static function accessEventManagement() : void {
        $events = FPersistentManager::getInstance()->retrieveAllEvents();
        print('AGGIUNGI EVENTO +' . "\n");
        print('-----------------------------------------------------------' . "\n");
        foreach($events as $event) {
            print('TITOLO: ' . $event->getTitle() . "\n");
            print('DATA: ' . $event->getDateAndTime()->format('Y-m-d') . "\n");
            print('AREA DI INTERVENTO: ' . $event->getFieldOfAction()->value . "\n");
            print('-----------------------------------------------------------' . "\n");
        }
    }

    public static function addEvent() : void {
        print('Inserire i dati dell\'evento' . "\n");
        print('Titolo: ' . "\n");
        print('Area di intervento: ' . "\n");
        print('Responsabile: ' . "\n");
        print('Data: ' . 'Ora: ' . 'Luogo: ' . "\n");
        print('Numero atteso di volontari: ' . "\n");
        print('Numero massimo di candidature accettabili: ' . "\n");
        print('Requisiti del candidato: ' . "\n");
    }

    public static function createEvent(
        string $title,
        string $dateAndTime,
        string $place,
        string $coordinator,
        int $requestedVolunteerNumber,
        int $maxVolunteerNumber,
        string $fieldOfAction,
        ?string $candidateRequirements
    ) : void {
        try {
            $event = new EEvent($title, $dateAndTime, $place, $coordinator, $requestedVolunteerNumber,
            $maxVolunteerNumber, $fieldOfAction, $candidateRequirements);
        } catch (Exception $e) {
            print("ERROR: " . $e->getMessage());
            exit();
        }
        
        if(FPersistentManager::getInstance()->storeObject($event)) {
            print('Nuovo evento creato con successo!');
        } else {
            print('ERRORE: creazione evento non riuscita');
        }

    }
}

?>