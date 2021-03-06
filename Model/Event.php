<?php

App::uses('AppModel', 'Model');


class Event extends AppModel {
    
    /**
     * Find and return the last 24h events
     * @todo Modify the return object to return the last 24h events
     */
    public function diary(){

        $time = time() - 3600*24;
        $date = date('Y-m-d H:i:s', $time);
        //search conditions
        $conditions = array(
            "date >" => $date,
                );
        //retrieve all active fighters
        return $this->find("all", array('conditions' => $conditions));
    }

    public function moveEvent($fighter, $previous_x, $previous_y){
        $x = $fighter['Fighter']['coordinate_x'];
        $y = $fighter['Fighter']['coordinate_y'];
        
        $event = $fighter['Fighter']['name'].' moved from ( '.
                $previous_x.' , '.$previous_y.' ) to ( '.$x.' , '.$y.' )';

        $this->create();
        $this->set(array(
            'name' => $event,
            'date' => date('Y-m-d H:i:s'),
            'coordinate_x'=>$x,
            'coordinate_y'=>$y
        ));
        
        $this->save();  
    }
    
    public function yellingEvent($fighter,$event){
        
        $this->create();
        $this->set(array(
            'name' => $event,
            'date' => date('Y-m-d H:i:s'),
            'coordinate_x'=>$fighter['Fighter']['coordinate_x'],
            'coordinate_y'=>$fighter['Fighter']['coordinate_y']
        ));
        
        $this->save();
    }
    
    public function attackEvent($fighter){
        
        $event = $fighter['Fighter']['name'].' attacked';

        $this->create();
        $this->set(array(
            'name' => $event,
            'date' => date('Y-m-d H:i:s'),
            'coordinate_x'=>$fighter['Fighter']['coordinate_x'],
            'coordinate_y'=>$fighter['Fighter']['coordinate_y']
        ));
        
        $this->save();  
    }
    
 
    public function newEvent($event, $fighter){

        $this->create();
        
        $this->set(array(
            'name' => $event,
            'date' => date('Y-m-d H:i:s'),
            'coordinate_x'=>$fighter['Fighter']['coordinate_x'],
            'coordinate_y'=>$fighter['Fighter']['coordinate_y']
        ));
        
        $this->save();    
    }
    
    public function fighterEvent($fighter){
        
        $event = 'Fighter '.$fighter['Fighter']['name'].' has been created';
        
        $this->create();
        
        $this->set(array(
            'name' => $event,
            'date' => date('Y-m-d H:i:s'),
            'coordinate_x'=>$fighter['Fighter']['coordinate_x'],
            'coordinate_y'=>$fighter['Fighter']['coordinate_y']
        ));
        
        $this->save(); 
        
        
        
        
        
    }
    
    
}

