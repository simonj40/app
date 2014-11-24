<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';
    public $belongsTo = array(
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

     /**
     * 
     * @param type $fighterId
     * @param type $direction
     * @todo empecher de sortir des limites de l’arène
     * @todo empecher d'entrer sur une case occupée
     */
    public function doMove($fighterId, $direction) {
        
        $this->read(null,$fighterId);
        $coordinate_x=$this->data['Fighter']['coordinate_x'];
        $coordinate_y=$this->data['Fighter']['coordinate_y'];
        
        if($direction=='north'){
            $coordinate_y+= 1;
        }else if($direction=='south'){
            $coordinate_y-= 1;
        }else if($direction=='east'){
            $coordinate_x+= 1;
        }else if($direction=='west'){
            $coordinate_x-= 1;
        }
        
        if(!$this->occupied($coordinate_x,$coordinate_y)){ 
            $this->set('coordinate_y',$coordinate_x);
            $this->set('coordinate_y',$coordinate_y);
            $this->set('next_action_time',date('Y-m-d H:i:s'));
            $this->save();
        }

    }
    
    public function occupied($coordinate_x,$coordinate_y){
        $condition=array(
            'coordinate_x'=>$coordinate_x,
            'coordinate_y'=>$coordinate_y
                );
        //Find the eventual victim in the database
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        
        if (empty($fighter)) return false;
        else return true;
    }
    
    
      /**
     * 
     * @param type $fighterId
     * @param type $direction
     */
    public function doAttack($fighterId, $direction){
        //get the fighter
        $fighter=$this->findById($fighterId);
        //Initialize the victim's coordinates with the fighter coordinates
        $victimeCoordinates= Array(
            'x'=>$fighter['Fighter']['coordinate_x'],
            'y'=>$fighter['Fighter']['coordinate_y']
        );

        //Calculate the victime coordinates according to the attack move
        if($direction=='north'){
            $victimeCoordinates['y']++;
        }else if($direction=='south'){
            $victimeCoordinates['y']--;
        }else if($direction=='east'){
            $victimeCoordinates['x']++;
        }else if($direction=='west'){
            $victimeCoordinates['x']--;
        }
        
        //Define search condition in the database
        $condition=array(
            'coordinate_x'=>$victimeCoordinates['x'],
            'coordinate_y'=>$victimeCoordinates['y']
                );
        //Find the eventual victim in the database
        $victim=$this->find( 'first', array( 'conditions' => $condition ) );
        
        if($victim==NULL){
            //NO VICTIM FOUND
            pr("NO VICTIM FOUND...");
        }else{
            //Calculate limit value
            $limit=10 + $victim['Fighter']['level'] - $fighter['Fighter']['level'];
            //If the attack suceed 
            if(rand(1,20)>$limit){      
                pr("ATTACK SUCCEDD !");
                //change...
                $this->attackSuceed($fighter,$victim);
                //update fighter level...
                $this->addLevel($fighter);
            }else{
                pr("ATTACK FAILED !");
            }

        }

        //Set next_action_time in the data base for the user
        $this->read(null,$fighter['Fighter']['id']);
        $this->set('next_action_time',date('Y-m-d H:i:s'));
        $this->save();
    }
    
        /**
     * Modify the data base data consequently to the successfull attack of the fighter over its victim
     * @param type $fighter
     * @param type $victim
     * @todo If Fighter xp%4==0 : then Fighter level +1 and user can decide to increase its sight, or health or strenght
     */
    public function attackSuceed($fighter,$victim){
        //get the Fighter from the data base
        $this->read(null,$fighter['Fighter']['id']);
        //The fighter get +1 xp
        $this->set('xp',$this->data['Fighter']['xp'] + 1);
        
        //Test if the victim got killed
        if($fighter['Fighter']['skill_strength']>=$victim['Fighter']['current_health']){
            //The attacker get xp + victim's level
            $this->set('xp',$this->data['Fighter']['xp'] + $victim['Fighter']['level']);
            $this->save();
            //delete the victim from the database
            $this->delete($victim['Fighter']['id']);
            
        }else{
            $this->save();
            //Victim's health got dimished according to the attacker strength
            $this->read(null,$victim['Fighter']['id']);
            $this->set('current_health',$this->data['Fighter']['current_health'] - $fighter['Fighter']['skill_strength']);
            $this->save();  
        }
        
    }
    
        public function createPlayer(){
        $this->set("id",$this->request->data["id"]);
    }
    
    public function addLevel($fighter) {
        //get total experience points from database
        $this->read(null,$fighter['Fighter']['id']);
        //set new level
        $this->set('level', round (($this->data['Fighter']['xp'])/4 ));        
    }

    public function doProtectBoundary($x, $y) {
        
    }

    public function doProtectOcupiedSpace() {
        
    }

}
