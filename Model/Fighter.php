<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

   );

    /**
     * 
     * @param type $fighterId
     * @param type $direction
     * @todo empecher de sortir des limites de l’arène
     * @todo empecher d'entrer sur une case occupée
     */
    public function doMove($fighterId, $direction){
        $this->read(null,$fighterId);
        
        if($direction=='north'){
            $this->set('coordinate_y',$this->data['Fighter']['coordinate_y'] + 1);
        }else if($direction=='south'){
            $this->set('coordinate_y',$this->data['Fighter']['coordinate_y'] - 1);
        }else if($direction=='east'){
            $this->set('coordinate_x',$this->data['Fighter']['coordinate_x'] + 1);
        }else if($direction=='west'){
            $this->set('coordinate_x',$this->data['Fighter']['coordinate_x'] - 1);
        }
            $this->save();
            
    }
    

public function doAttack($id,$direction){
    //successful attack 
    //generate random number between 1 and 20
    $al = rand(1,20);
    // compute the success level
    if($id == 1){
    $limit = 10 + $this->data[$id]["Fighter"]["level"] - $this->data[$id-1]["Fighter"]["level"];
    }
    elseif($id==2){
         $limit = 10 + $this->data[$id-1]["Fighter"]["level"] - $this->data[$id-2]["Fighter"]["level"];
    }
    //success condition
    if($al >$limit){
        //attackee looses a point of life 
        $this-> set("current_health",$this->data[$id-1]["Fighter"]["current_health"]-1);
    }
    
    $this->save();
    }


}

