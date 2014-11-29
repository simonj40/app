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
        
        //retrieve my fighter
        $conditions1 = array("player_id" => $playerId);
        $myFighter = $this->Fighter->find('first', array('conditions' => $conditions1));
        $sight = $myFighter['Fighter']['skill_sight'];
        $sight++;
        $x = $myFighter['Fighter']['coordinate_x'];
        $y = $myFighter['Fighter']['coordinate_y'];
        
        //time condition
        $time = time() - $this->time_before_disconnected;
        $date = date('Y-m-d H:i:s', $time);
        //search conditions
        $conditions2 = array(
            "next_action_time >" => $date,
                );
        //retrieve all active fighters
        $fighters = $this->Fighter->find("all", array('conditions' => $conditions2));

        $fighters_array = array();
        //Field the array to be sent with all active visible fighters
        foreach ($fighters as $fighter) {
            $fighter_x = $fighter['Fighter']['coordinate_x'];
            $fighter_y = $fighter['Fighter']['coordinate_y'];

            //check if fighter is at my fighter sight
            if($fighter_x <= $x+$sight && $fighter_x >= $x-$sight){
                if($fighter_y <= $y+$sight && $fighter_y >= $y-$sight){
                    array_push($fighters_array, $fighter['Fighter']);
                }
            }  
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









