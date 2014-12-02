<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {
    
    public $boardX=15;
    public $boardY=10;
    public $time_before_disconnected = 60;

    public $displayField = 'name';
    public $belongsTo = array(
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Guild' => array(
            'className' => 'Guild',
            'foreignKey' => 'guild_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    
    public function update_next_action_time($playerId){

        
        $condition=array(
            'player_id'=>$playerId,
                );
        
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        $this->read(null,$fighter['Fighter']['id']);
        $this->set('next_action_time',date('Y-m-d H:i:s'));
        $this->save();
    }
    
    
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
        
        if(!$this->occupied($coordinate_x,$coordinate_y) && !$this->outOfBounds($coordinate_x,$coordinate_y)){ 
            $this->set('coordinate_x',$coordinate_x);
            $this->set('coordinate_y',$coordinate_y);
            $this->set('next_action_time',date('Y-m-d H:i:s'));
            $this->save();
            return true;
        }else return false;

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
    public function doAttack($fighter, $direction){
        //Initialize the victim's coordinates with the fighter coordinates
        $victimeCoordinates= Array(
            'x'=>$fighter['Fighter']['coordinate_x'],
            'y'=>$fighter['Fighter']['coordinate_y']
        );
        
        $event = '';
        $message = '';

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
        
        $time = time() - $this->time_before_disconnected;
        $date = date('Y-m-d H:i:s', $time);
        
        //Define search condition in the database
        $condition=array(
            'coordinate_x'=>$victimeCoordinates['x'],
            'coordinate_y'=>$victimeCoordinates['y'],
            'next_action_time >'=>$date
                );
        
        //Find the eventual victim in the database
        $victim=$this->find( 'first', array( 'conditions' => $condition ) );
        
        if($victim==NULL){
            //NO VICTIM FOUND
            $event = $fighter['Fighter']['name'].' attacked '.' but no victim was found';
            $message = 'NO VICTIM FOUND...';
        }else{
            //Calculate limit value
            $limit=10 + $victim['Fighter']['level'] - $fighter['Fighter']['level'];
            //If the attack suceed 
            if(rand(1,20)>$limit){      
                //change...
                $this->attackSuceed($fighter,$victim);
                //update fighter level...
                $this->addLevel($fighter);
                
                $event = $fighter['Fighter']['name'].' attacked '.$victim['Fighter']['name'].' and succeed';
                
                $message = 'ATTACK SUCCEDD !';
            }else{
                $event = $fighter['Fighter']['name'].' attacked '.$victim['Fighter']['name'].' and failed';
                
                $message = 'ATTACK FAILED !';
            }

        }
        
        $response = array($message,$event);
        
        return $response;
        
    }
    
        /**
     * Modify the data base data consequently to the successfull attack of the fighter over its victim
     * @param type $fighter
     * @param type $victim
     * @todo If Fighter xp%4==0 : then Fighter level +1 and user can decide to increase its sight, or health or strenght
     */
    public function attackSuceed($fighter,$victim){
        //get the Fighter from the data base
        $this->read(null, $fighter['Fighter']['id']);
        //The fighter get +1 xp
        $this->set('xp',$this->data['Fighter']['xp'] + 1);
        
        $fighter_strenght = $this->strength_guild($fighter);
        
        //$fighter_strenght = $fighter['Fighter']['skill_strength'];
        
        //Test if the victim got killed
        if($fighter_strenght >= $victim['Fighter']['current_health']){
            //The attacker get xp + victim's level
            $this->set('xp',$this->data['Fighter']['xp'] + $victim['Fighter']['level']);
            $this->save();
            //delete the victim from the database
            $this->delete($victim['Fighter']['id']);
            //delete its avatar
            $this->deleteAvatar($victim['Fighter']['player_id']);
            
        }else{
            $this->save();
            //Victim's health got dimished according to the attacker strength
            $this->read(null,$victim['Fighter']['id']);
            $this->set('current_health',$this->data['Fighter']['current_health'] - $fighter_strenght);
            $this->save();  
        }
        
    }
    
    public function strength_guild($fighter){
        
        $guild_id = $fighter['Fighter']['guild_id'];  
        $strength = $fighter['Fighter']['skill_strength'];  
        if($guild_id != ''){
            //If in a guild 
            $condition=array(
            'guild_id'=>$guild_id
                );
            
           $guild_count =  $this->find( 'count', array( 'conditions' => $condition ) );
           $strength += $guild_count - 1;
        }
        
        return $strength;
    }
    
    public function deleteAvatar($playerId){     
        $avatarPath = WWW_ROOT.'img/avatars/'.$playerId.'.png';
        unlink($avatarPath); 
    } 
    
    
    public function addLevel($fighter) {
        //get total experience points from database
        $this->read(null,$fighter['Fighter']['id']);
        //set new level
        $this->set('level', round (($this->data['Fighter']['xp'])/4 ));        
    }

    public function outOfBounds($x, $y) {
        if($x>=$this->boardX || $y>=$this->boardY || $x<0 || $y<0 ) return true;
        else return false;
    }

    
    public function findPlayersFighter($playerId){
        $condition=array(
            'player_id'=>$playerId,
                );
        //Find the eventual victim in the database
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        return $fighter;
    }

    public function nameExist($name){
        
        $condition=array(
            'name'=>$name,
                );
        //Find the eventual victim in the database
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        
        if(empty($fighter)) return false;
        else return true;
    }
    
    public function generateXY(){
        $occupied=true;
        $x;
        $y;
        while($occupied){
            $x = rand(0, $this->boardX-1);
            $y = rand(0, $this->boardY-1);
            $occupied = $this->occupied($x,$y);
            $outOfBound =$this->outOfBounds($x,$y);
            $occupied = $occupied && !$outOfBound;

        }
        
        $coordinates = array(
            'x'=>$x,
            'y'=>$y
             );
            
        return $coordinates;
        
    }

    public function newFighter($playerId, $name){

            $coordinates = $this->generateXY();
            $this->create();
            $this->set(array(
                'name' => $name,
                'player_id' => $playerId,
                'coordinate_x'=>$coordinates['x'],
                'coordinate_y'=>$coordinates['y'],
                'level'=>0,
                'xp'=>0,
                'skill_sight'=>0,
                'skill_strength'=>1,
                'skill_health'=>0,
                'current_health'=>3,
                'next_action_time'=>date('Y-m-d H:i:s'),
            ));
            $this->save();  

    }
    
        /**
     * Retrieve level, xp, skills 
     * 
     */
    public function retrieveLevelSkills($playerId){
        $condition=array(
            'player_id'=>$playerId
                );
        //Find fighter details for associated player id
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        //compute details
        $unusedXP = $this->checkUpgradePossible($fighter);
        $fighterDetails = array(
            "xp" => $fighter['Fighter']['xp'],
            "level" => $fighter['Fighter']['level'],
            "skill_sight" => $fighter['Fighter']['skill_sight'],
            "skill_strength" => $fighter['Fighter']['skill_strength'],
            "skill_health" => $fighter['Fighter']['skill_health'],
            "current_health" => $fighter['Fighter']['current_health'],
            "current_position_x" => ($fighter['Fighter']['coordinate_x']),
            "current_position_y" => ($fighter['Fighter']['coordinate_y']),
            "unusedXP" => $unusedXP
        );
        
        return $fighterDetails;
        
    }
    
    /**
     * check if player can increase fighter skills
     */
    private function checkUpgradePossible($fighter){
        return ((floor($fighter['Fighter']['xp']/4) - $fighter['Fighter']['level']) * 4);
    }
    
    /**
     * upgrade fighter level
     */
    private function upgradeLevel($fighter, $fieldToUpdate, $valueToUpdate){
        $this->read(null,$fighter['Fighter']['id']);
        $this->set($fieldToUpdate, $valueToUpdate);
        $this->save();        
    }

    /**
     * Update level, xp, skills as per players choice
     * @param type $fighter
     */
    public function updateLevelSkills($playerId, $skillsToUpgrade) {
        $response=''; 
        $condition=array(
            'player_id'=>$playerId
                );
        //retrieve current status for fighter
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        if ($skillsToUpgrade == 'view'){
            if($this->checkUpgradePossible($fighter)>= 1){
                $this->upgradeLevel($fighter, 'level', ($fighter['Fighter']['level'] + 1));
                $this->upgradeLevel($fighter, 'skill_sight', ($fighter['Fighter']['skill_sight'] + 1));
                $response = "Your view has been upgraded +1";
            } else {
                $response = "You do not have enough spare xp to increase view skill.";                
            }
            
        }elseif ($skillsToUpgrade == 'strength') {
            if($this->checkUpgradePossible($fighter)>= 1){
                $this->upgradeLevel($fighter, 'level', ($fighter['Fighter']['level'] + 1));
                $this->upgradeLevel($fighter, 'skill_strength', ($fighter['Fighter']['skill_strength'] + 1));
                 $response = "Your strength has been upgraded +1";                
            } else {
                $response = "You do not have enough spare xp to increase strength skill.";                
            }
            
        }  elseif ($skillsToUpgrade == 'lifepoints'){
            if($this->checkUpgradePossible($fighter)>= 3){
                $this->upgradeLevel($fighter, 'level', ($fighter['Fighter']['level'] + 1));
                $this->upgradeLevel($fighter, 'current_health', ($fighter['Fighter']['current_health'] + 3));
                $this->upgradeLevel($fighter, 'skill_health', ($fighter['Fighter']['skill_health'] + 1));
                 $response = "Your life points have been upgraded +3";
            } else {
                $response = "You do not have enough spare xp to increase life points.";                
            }
            
        }else{
            $response = "Error upgrading your fighter.";            
        }
        
        return $response;
           
    }
    
    
      /**
     * Join a player's fighter to an existing guild
     * @param type $fighterId
     * @param type $guildId
     */
    public function joinExistingGuild($fighterId, $guildId){
        $this->read(null, $fighterId);
        $this->set('guild_id', $guildId);
        $this->save();      
        
    }
    /**
     * Leave player from guild
     * @param type $fighterId
     */
    public function leaveGuild($fighterId){
        
        $this->read(null, $fighterId);
        $this->set('guild_id', null);
        $this->save();       
    }
    
     /**
     * Check whether a player's fighter is already in an existing guild
     */    
    public function checkExistInGuild($playerId){
         $condition=array(
            'player_id'=>$playerId
                );
        //retrieve fighter details...
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        if($fighter['Fighter']['guild_id'] != null){
            //fighter is in a guild!
            return true;
        }else{
            //fighter not in any existing guild
            return false;
        }
    }
    
    public function retrievePlayerGuild($playerId){
         $condition=array(
            'player_id'=>$playerId
                );
        //retrieve fighter details...
        $fighter=$this->find( 'first', array( 'conditions' => $condition ) );
        return $fighter;
    }
    
    
    
}
