<?php 

enum EApplicationState: string {
    
    case WAITING = 'In attesa di valutazione';
    case APPROVED = 'Approvata';
    case REJECTED = 'Rifiutata';
    case WITHDRAWN = 'Ritirata';
}

?>