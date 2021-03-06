<?php 

App::uses('AppController', 'Controller');

class UpgradeController extends AppController{
    
    public $uses = array('Fighter', 'Guild');
    /**
     * Method to retrieve level and skill details of a fighter for a specific player
     */
    public function retrieveLevelSkills(){
        //set response type
        $this->response->type('json');    
        $this->autoRender = false; 
        
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
        $this->request->onlyAllow('ajax'); 
        
        $guilds = $this->Guild->find('all');
        //$fighters = $this->Fighter->find('all');
        //return json
         $json = json_encode($guilds);        
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
    
    public function leaveGuild(){
        $this->autoRender = false; 
        $this->request->onlyAllow('ajax'); 
        
        $playerId = $this->Session->read('PlayerId'); 
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        
        $this->Fighter->leaveGuild($fighter['Fighter']['id']);
        
        $this->response->body($fighter['Fighter']['id']);
        
    }
    
    public function joinGuild(){
        $this->autoRender = false; 
        $this->request->onlyAllow('ajax'); 
        $guilId = $this->request->data['guildId'];
        
        $playerId = $this->Session->read('PlayerId');
        $fighter = $this->Fighter->findPlayersFighter($playerId,$guilId);
        
        $this->Fighter->joinExistingGuild($fighter['Fighter']['id'], $guilId);
        
        $this->response->body($fighter['Fighter']['id']);
        
    }
    
    public function createGuild(){
        $this->autoRender = false; 
        $this->request->onlyAllow('ajax'); 
        $guilName = $this->request->data['name'];
        
        $playerId = $this->Session->read('PlayerId');
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        
        $guildId = $this->Guild->createGuild($guilName);
        
        $this->Fighter->joinExistingGuild($fighter['Fighter']['id'], $guildId);
        
        $this->response->body($guildId);
        
        
    }
    
    
    
    
    
   
}