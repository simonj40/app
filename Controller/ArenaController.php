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
    
    
    public function beforeFilter(){
        
        $login = $this->Session->read('Connected');
        $method = $this->request->params['action'];   

        pr($login);
        if($login==NULL && $method!='login' && $method!='signin' && $method!='forgot' && $method!='recover'){
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
        }
        
    }
    
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
        $login;
        
        if ($this-> request-> is ('post')){
               $login=$this->Player->checkLogin( $this->request->data['Login']['Email'], $this->request->data['Login']['Password'] );
               if($login){
                   $this->Session->write('Connected', $this->request->data['Login']['Email']);
                   $this->redirect(array('controller' => 'Arena', 'action' => 'index'));
               }
               else $this->Session->setFlash('Failed !');
        }
        
    }
    
    public function logout(){
        
        $this->Session->delete('Connected');
        $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
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
                $fighter = $this->Fighter->findById($fighterId);
                $this->Event->moveEvent($fighter);

            }else if($this->request->data('Fighterattack')!=NULL && $this->request->data('Fighterattack')!=''){
                $this->Fighter->doAttack($fighterId,$this->request->data['Fighterattack']);
                //Set Event
                $this->Event->moveAttack($fighter);
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
    
    
     public function signin()
    {   
         $error='';
        if ($this-> request-> is ('post')){
               $error=$this->Player->createNew( $this->request->data['Subscribe']['Email'], $this->request->data['Subscribe']['Password'] );
               $this->Session->setFlash($error);
        }
        
        
    }
    
    
    public function forgot()
    {   
        if ($this-> request-> is ('post')){
               $email=$this->request->data['Forgot']['Email'];
               $player=$this->Player->findPlayer($email);
               if($player!=NULL){
                   $password=$player['Player']['password'];
                   $link='http://localhost/WebArenaGoupSI1-04-BE/Arena/recover/';
                   $link.=$email;
                   $link.='/';
                   $link.=$password;
                   
                   //Send E-mail with link to recover
                    $Email = new CakeEmail();
                    $Email->from(array('admin@Arena.com' => 'Arena'));
                    $Email->to($email);
                    $Email->subject('Password Recovery Link');
                    $Email->send($link);
                    
                    $this->Session->setFlash('An Email has been sent to you');
               }else{
                   $this->Session->setFlash('The account does not exist');
               }    
        } 
    }
    
    
    public function recover($email,$password)
    {   
        if ($this-> request-> is ('post')){
            $this->set('email',$email);
            $this->set('password',$password);
            
            $success = $this->Player->recover($this->request->data['Recover']['Email'],
                    $this->request->data['Recover']['Password'], $this->request->data['Recover']['New Password']);
            
            if($success) $this->Session->setFlash('Password change succeed !');
            else $this->Session->setFlash('Password change failed !');
        }else if($this->Player->checkPassword($email,$password)){
            $this->set('email',$email);
            $this->set('password',$password);
        }else $this->redirect(array('controller' => 'Arena', 'action' => 'forgot'));

    }
    
    /**
     * This is just for testing bootstrap
     */
    public function testbootstrap()
    {
        
    }
    
    
    
    

}
?>
