<?php 

App::uses('AppController', 'Controller');


/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController
{
    
    public $uses = array('Player', 'Fighter', 'Event');
    
    /**
     * index method : first page
     *
     * @return void
     */
    public function index()
    {
        $this->set('myname', "Simon");

    }
    /**
     * @todo
     */
    public function login()
    {

    }
    
    /**
     * @todo Implement the Event management function in the Model Event consequently to a move of an attack
     */
    public function sight()
    {
        $components = array( 'Session' );
        $this->Session->setFlash('Une action a été réalisée.');
        $this->set('fighters', $this->Fighter->find('all'));
        $fighterId=1;

        if ($this-> request-> is ('post')){
            
            if($this->request->data('Fightermove')!=NULL && $this->request->data('Fightermove')!=''){
                $this->Fighter->doMove($fighterId,$this->request->data['Fightermove']); 
                //Set Event

            }else if($this->request->data('Fighterattack')!=NULL && $this->request->data('Fighterattack')!=''){
                $this->Fighter->doAttack($fighterId,$this->request->data['Fighterattack']);
                //Set Event
            }
        }

    }
    
    
    public function fighter()
    {
        $this->set('raw',$this->Fighter->find());
		//changes
    }
    
    /**
     * 
     */
    public function diary()
    {   
        $events=$this->Event->diary();
        $this->set('events',$events);  
    }
    
    /**
     * This is just for testing bootstrap
     */
    public function testbootstrap()
    {
        
    }

}
?>
