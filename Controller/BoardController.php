<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class BoardController extends AppController
{
    
    
    public $uses = array('Player', 'Fighter', 'Event','Message');
    
    public $time_before_disconnected = 60;

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
    
    public function yell(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $response = '';

        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $yelling = $this->request->data['yelling'];
       
        $event = $fighter['Fighter']['name'].' yelled "'.$yelling.'"';
        
        if(!empty($fighter)){
                        $this->Event->yellingEvent($fighter,$event);                  
        }
            $this->response->body('Your yelling has been heard');
         
    }
    
    public function move(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $response = '';

        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $direction = $this->request->data['direction'];
        
        $previous_x = $fighter['Fighter']['coordinate_x'];
        $previous_y = $fighter['Fighter']['coordinate_y'];
       
        if(!empty($fighter)){
            $fighterId=$fighter['Fighter']['id'];           
            $success = $this->Fighter->doMove($fighterId, $direction);
            if($success){
                        //Set Event
                        $fighter = $this->Fighter->findById($fighterId);
                        $this->Event->moveEvent($fighter, $previous_x, $previous_y);
                        $response = 'Move succeed !';
            }else $response = 'Move Not Possible...';
        }
            $this->response->body($response);
         
    }
    
    public function attack(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $message = '';

        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        
        $direction = $this->request->data['direction'];
        
        if(!empty($fighter)){
            $fighterId = $fighter['Fighter']['id'];  
            $response = $this->Fighter->doAttack($fighter,$direction);
            //Set Event
            $this->Event->newEvent($response[1],$fighter);  
            $message = $response[0];
        }else $message = 'An Error Occured...';
        
            $this->response->body($message);
    }

    //to delete
    public function test(){
        
        $messages = $this->Message->find('all');
        
        pr($messages);
        
        
        
    } 
    
}









