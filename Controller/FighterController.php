<?php 

App::uses('AppController', 'Controller');

class FighterController extends AppController{
    
    public $uses = array('Fighter', 'Guild');
    
    /**
     * Method to retrieve level and skill details of a fighter for a specific player
     */
    public function retrieveLevelSkills(){
        $this->autoRender = false; 
        //set response type
        //$this->request->onlyAllow('ajax'); 
        $this->response->type('json');    
        
        
        //retrieve fighter object for current player from the model
        $playerId = $this->Session->read('PlayerId');  
        $FighterDetails = $this->Fighter->retrieveLevelSkills($playerId);
        
        
        
        //return json object
         $json = json_encode($FighterDetails);  
         
         $this->response->body($json);        
         
        
    }
    
    public function updateLevelSkills(){
          
        $this->autoRender = false; 
        $this->request->onlyAllow('ajax'); 
        $skillToUpgrade = $this->request->data['skillToUpgrade'];
                
        $playerId = $this->Session->read('PlayerId');  
        $upgradeResponse = $this->Fighter->updateLevelSkills($playerId, $skillToUpgrade);
        
         //return json object
         $json = json_encode($upgradeResponse);        
         $this->response->body($json); 
        
    } 
    
       
    public function checkUserInGuild(){
        $this->autoRender = false; 
        //$this->request->onlyAllow('ajax'); 
        $playerId = $this->Session->read('PlayerId');
        $userInGuild = $this->Fighter->checkExistInGuild($playerId);
        //return json
        //$json = json_encode($userInGuild);        
         $this->response->body($userInGuild);
    }
    
     public function retrieveAllGuilds(){
        $this->autoRender = false; 
        //$this->request->onlyAllow('ajax'); 
        
        $allGuilds = $this->Guild->retrieveAllGuilds();
        
        //return json
        $json = json_encode($allGuilds);        
         $this->response->body($json);
    }
    
    public function findGuildId(){
         $playerId = $this->Session->read('PlayerId');
         $guildRef = $this->Fighter->retrievePlayerGuild($playerId); 
         return $guildRef;
    }
    
   public function retrievePlayersGuild(){
        $this->autoRender = false; 
        //$this->request->onlyAllow('ajax'); 
        $playerId = $this->Session->read('PlayerId');
        $playersGuild=$this->Fighter->retrievePlayerGuild($playerId);
        
        //return json
        $json = json_encode($playersGuild);        
         $this->response->body($json);
    }
    
   
}