<?php

App::uses('AppModel', 'Model');


class Guild extends AppModel {    
    

    public function createGuild($name){
        $this->create();
        $this->set(array(
           'name' => $name
        ));
        $this->save(); 
        
        return $this->getInsertID();
        
    }
    

}

