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

    public function plot(){
        
        $this->autoRender = false; // We don't render a view in this example
        $this->request->onlyAllow('ajax'); // No direct access via browser URL
        $this->response->type('json');
        
        $plot = array();
        
        
        for($i=1;$i<20;$i++){
            
            $dot = array($i,$i*$i);
            array_push($plot, $dot);
        }
        
        $array2 = array($plot);
        
        
        $json = json_encode($array2);
        
        $this->response->body($json);
        
    }
    
    
}









