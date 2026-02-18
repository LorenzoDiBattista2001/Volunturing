<?php

class CSubmitApplication {

    public static function showEvents() : void {
        $scheduledEvents = FPersistentManager::getInstance()->retrieveScheduledEvents();
        foreach($scheduledEvents as $event) {
            print('TITOLO: ' . $event->getTitle() . "\n");
            print('DATA: ' . $event->getDateAndTime()->format('Y-m-d') . "\n");
            print('AREA DI INTERVENTO: ' . $event->getFieldOfAction()->value . "\n");
            print('-----------------------------------------------------------' . "\n");
        }
    }

    public static function selectEvent(int $eventId) : void {
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        print('TITOLO: ' . $event->getTitle() . "\n");
        print('DATA: ' . $event->getDateAndTime()->format('Y-m-d') . "\n");
        print('ORA: ' . $event->getDateAndTime()->format('H:i:s') . "\n");
        print('AREA DI INTERVENTO: ' . $event->getFieldOfAction()->value . "\n");
        print('NUMERO VOLONTARI ATTESI: ' . $event->getRequestedVolunteerNumber() . "\n");
        print('LUOGO: ' . $event->getPlace() . "\n");
        print('RESPONSABILE: ' . $event->getCoordinator() . "\n");
        $requirements = $event->getCandidateRequirements() ? $event->getCandidateRequirements() : 'nessuno';
        print('REQUISITI RICHIESTI AL VOLONTARIO: ' . $requirements);
    }

    public static function startApplicationProcess(int $userId, int $eventId) : void {
        if (FPersistentManager::getInstance()->existApplication($userId, $eventId)) {
            print('Impossibile candidarsi: utente già candidato');
            exit();
        }
        $event = FPersistentManager::getInstance()->loadEvent($eventId);
        if($event->isFull()) {
            print('Impossibile candidarsi: posti esauriti');
            exit();
        }
        print('Cosa ti spinge a partecipare?' . "\n");
        print('.............................' . "\n");
        print('Conferma Candidatura');
    }

    public static function createApplication(?string $message, int $userId, int $eventId) : void {
        $application = new EApplication(date('Y-m-d H:i:s'), EApplicationState::WAITING, $message);
        $application->setUserId($userId);
        $application->setEventId($eventId);
        FPersistentManager::getInstance()->storeObject($application);
        print("Candidatura inviata con successo!");
    }


}

?>