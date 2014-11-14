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
    
    public function login()
    {

    }
    
    public function character()
    {
        $this->set('raw',$this->Fighter->findById(1));

    }
    
    public function sight()
    {
        $this->set('fighters', $this->Fighter->find('all'));

        if ($this-> request-> is ('post')){
            
            if($this->request->data('Fightermove')!=NULL && $this->request->data('Fightermove')!=''){
                $this->Fighter->doMove(1,$this->request->data['Fightermove']);     
            }else if($this->request->data('Fighterattack')!=NULL && $this->request->data('Fighterattack')!=''){
                $this->Fighter->doAttack(1,$this->request->data['Fighterattack']);
            }
        }

    }
    
    public function fighter()
    {
        $this->set('raw',$this->Fighter->find());
		//changes
    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }

}
?>
