<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class DiaryController extends AppController
{

    public $uses = array('Event');
    
    public $event_age = 86400;

    public function diaryInit(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        $time = time() - $this->event_age;
        $date = date('Y-m-d H:i:s', $time);
        //search conditions
        $conditions = array(
            "date >" => $date,
                );
        
        $events = $this->Event->find('all', array('conditions' => $conditions));
        
        
        $events_array = array();
        
        foreach ($events as $event){
            
            $event_array = array( 
                            'Date'=>$event['Event']['date'],
                            'Event'=>$event['Event']['name'],
                            'Position'=>'( '.$event['Event']['coordinate_x'].' , '.$event['Event']['coordinate_y'].' )'
            );
            
            array_push($events_array, $event_array);
        }
        
        
        $json = json_encode($events_array);
        
        $this->response->body($json);
        
    }
    
    
    
    
    
    
}









