<?php 

App::uses('AppController', 'Controller');

class UpgradeController extends AppController{
    
    public $uses = array('Fighter');
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
   
}