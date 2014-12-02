<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class IndexController extends AppController
{
    public $uses = array('Player', 'Fighter', 'Event','Message');
    
    public $time_before_disconnected = 30;
    
    public function plot_events(){
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        
        
        $array = $this->_nbConnexion();
        $json = json_encode($array);
        
        $this->response->body($json);
        
    }
    
    public function plot_fighters(){
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        
        $fighters = $this->Fighter->find('all');
        
        $json = json_encode($fighters);
        
        $this->response->body($json);
        
    }
    
    protected function _nbConnexion(){
        
        $day_no = 7;
        
        $day = 3600*24;
        $t1 = 0;
        $t2 = $day;
        $array = array();
        for($i=0;$i<$day_no;$i++){
             
            $time1 = time() - $t1;
            $date1 = date('Y-m-d H:i:s', $time1);
            $date_axis = date('Y-m-d', $time1);
            
            $time2 = time() - $t2;
            $date2 = date('Y-m-d H:i:s', $time2);
            //search conditions
            $conditions = array(
                "date <" => $date1,
                "date >" => $date2
                    );
            //retrieve all active fighters
           $event_count =  $this->Event->find("count", array('conditions' => $conditions));
           $array_dot = array(
                       $date_axis=> $event_count
           );
           array_push($array, $array_dot);
           
           $t1+=$day;
           $t2+=$day;
        }
        
        return $array;
    }
}









