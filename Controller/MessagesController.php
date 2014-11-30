<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class MessagesController extends AppController
{

    public $uses = array('Message', 'Fighter');

    public function messages_init(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        
        
        
        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $fighterId = $fighter['Fighter']['id'];
        
        $messages = $this->Message->find('all');
 
        $messages_array = array();
        
        foreach ($messages as $message){
            
            if($message['Message']['fighter_id_from'] == $fighterId){
                $message_array = array(
                                        'Date'=>$message['Message']['date'],
                                        'From'=>'Me ('.$message['FighterFrom']['name'].')',
                                        'To'=>$message['Fighter']['name'],
                                        'Title'=>$message['Message']['title'],
                                        'Message'=>$message['Message']['message'],
                                    );
                
                array_push($messages_array, $message_array);
            }
            if($message['Message']['fighter_id'] == $fighterId){
                $message_array = array(
                                        'Date'=>$message['Message']['date'],
                                        'From'=>$message['FighterFrom']['name'],
                                        'To'=>'Me ('.$message['Fighter']['name'].')',
                                        'Title'=>$message['Message']['title'],
                                        'Message'=>$message['Message']['message'],
                                    );
                
                array_push($messages_array, $message_array);
                
            }  
        }
        

        $json = json_encode($messages_array);
        
        $this->response->body($json);
        
    }
    
    
    public function message_refresh(){
        
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $fighterId = $fighter['Fighter']['id'];
        
        $conditions = array(
            "date >" => $this->request->data['date'],
                );

        //retrieve all active fighters
        $messages = $this->Message->find("all", array('conditions' => $conditions));
        
        $messages_array = array();
        
        foreach ($messages as $message){
            
            if($message['Message']['fighter_id_from'] == $fighterId){
                $message_array = array(
                                        'Date'=>$message['Message']['date'],
                                        'From'=>'Me ('.$message['FighterFrom']['name'].')',
                                        'To'=>$message['Fighter']['name'],
                                        'Title'=>$message['Message']['title'],
                                        'Message'=>$message['Message']['message'],
                                    );
                
                array_push($messages_array, $message_array);
            }
            if($message['Message']['fighter_id'] == $fighterId){
                $message_array = array(
                                        'Date'=>$message['Message']['date'],
                                        'From'=>$message['FighterFrom']['name'],
                                        'To'=>'Me ('.$message['Fighter']['name'].')',
                                        'Title'=>$message['Message']['title'],
                                        'Message'=>$message['Message']['message'],
                                    );
                
                array_push($messages_array, $message_array);
                
            }  
        }
        
        $json = json_encode($messages_array);

        $this->response->body($json);
    }
    
    public function message(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $message = '';
        
        $playerId = $this->Session->read('PlayerId');  
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        $fighterIdFrom = $fighter['Fighter']['id'];
        
        $fighterToId = $this->request->data['fighterTo']; 
        $title =  $this->request->data['title']; 
        $message = $this->request->data['message'];
        
        $this->Message->new_message($fighterIdFrom, $fighterToId, $title, $message);
        $this->response->body('message Sent');

    }
    
    public function test(){
        
        
        $time = time();
        $date = date('Y-m-d H:i:s', $time);
        
        $this->set('date',$this->last_update);
        pr($this->last_update);
        $this->last_update = $date;
        
        
    }
    
    
    
}









