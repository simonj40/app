<?php

App::uses('AppModel', 'Model');


class Message extends AppModel {
    
    
    public $belongsTo = array(
        'Fighter' => array(
            'className' => 'Fighter',
            'foreignKey' => 'fighter_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'FighterFrom' => array(
            'className' => 'Fighter',
            'foreignKey' => 'fighter_id_from',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    
    
    public function new_message($fighterIdFrom, $fighterToId, $title, $message){
        $this->create();
        $this->set(array(
            'date' => date('Y-m-d H:i:s'),
            'title' => $title,
            'message'=>$message,
            'fighter_id_from'=>$fighterIdFrom,
            'fighter_id'=>$fighterToId
        ));
        
        $this->save();
        
         
    }

}

