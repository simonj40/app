<?php

App::uses('AppModel', 'Model');

class Event extends AppModel {
    
    /**
     * Find and return the last 24h events
     * @todo Modify the return object to return the last 24h events
     */
    public function diary(){
        
        return $this->find('all');
        
    }
 
}

