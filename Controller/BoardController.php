<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class BoardController extends AppController
{
    
    public $uses = array('Player', 'Fighter', 'Event');
    
    public $time_before_disconnected = 5;

    public function board(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        //Update next_action_time
        $playerId = $this->Session->read('PlayerId');  
        
        $this->Fighter->update_next_action_time($playerId);
        
        $time = time() - $this->time_before_disconnected;
        $date = date('Y-m-d H:i:s', $time);

        $conditions = array("next_action_time >" => $date);

        $fighters = $this->Fighter->find("all", array('conditions' => $conditions));

        $fighters_array = array();

        foreach ($fighters as $fighter) {   
            array_push($fighters_array, $fighter['Fighter']);
        }

        $json = json_encode($fighters_array);
        
        $this->response->body($json);

    }
    
    public function move(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $response = '';

        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $direction = $this->request->data['direction'];
       
        if(!empty($fighter)){
            $fighterId=$fighter['Fighter']['id'];           
            $success = $this->Fighter->doMove($fighterId, $direction);
            if($success){
                        //Set Event
                        $fighter = $this->Fighter->findById($fighterId);
                        $this->Event->moveEvent($fighter);
                        $response = 'Move succeed !';
            }else $response = 'Move Not Possible...';
        }
            $this->response->body($response);
         
    }
    
    public function attack(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $response = '';

        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $direction = $this->request->data['direction'];
        
        if(!empty($fighter)){
            $fighterId = $fighter['Fighter']['id'];  
            $success = $this->Fighter->doAttack($fighterId,$direction);
            //Set Event
            $this->Event->attackEvent($fighter);  
            $response = $success;
        }else $response = 'ATTACK FAILED !';

            $this->response->body($response);
    }
    
}









