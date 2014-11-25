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
        $login = $this->Session->read('Connected');
        $this->set('myname', $login);

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
                   $player = $this->Player->findPlayer($this->request->data['Login']['Email']);
                   $this->Session->write('PlayerId',$player['Player']['id']);
                   $this->redirect(array('controller' => 'Arena', 'action' => 'index'));
               }
               else $this->Session->setFlash('Failed !');
        }
        
    }
    
    public function logout(){
        
        $this->Session->delete('Connected');
        $this->Session->delete('PlayerId');
        $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
    }
    
    /**
     * @todo implement the view with the other fighter on the board
     */
    public function sight()
    {
        //$components = array( 'Session' );
        $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
        if(!empty($fighter)){
            $this->set('fighter', $fighter);
            $fighterId=$fighter['Fighter']['id'];
            if ($this-> request-> is ('post')){ 
                if($this->request->data('Fightermove')!=NULL && $this->request->data('Fightermove')!=''){
                    $success = $this->Fighter->doMove($fighterId,$this->request->data['Fightermove']); 

                    if($success){
                        //Set Event
                        $fighter = $this->Fighter->findById($fighterId);
                        $this->Event->moveEvent($fighter);
                        $this->Session->setFlash('Move succeed !');
                    }else $this->Session->setFlash('Move Not Possible...');

                }else if($this->request->data('Fighterattack')!=NULL && $this->request->data('Fighterattack')!=''){
                    $success = $this->Fighter->doAttack($fighterId,$this->request->data['Fighterattack']);
                    //Set Event
                    $this->Event->attackEvent($fighter);
                    $this->Session->setFlash($success);
                }
            }

            $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
            $this->set('fighter', $fighter);
        }else $this->redirect(array('controller' => 'Arena', 'action' => 'fighter_form'));

    }
    
    /**
     *@todo implement level upgrade adn skills etc ...
     */
    public function fighter()
    {    
        $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
        if(!empty($fighter)){
            $this->set('fighter',$fighter);
            
        }else{
            $this->redirect(array('controller' => 'Arena', 'action' => 'fighter_form'));
        }

    }
    
    /**
     * @todo Implement the Avavtar download and file namng with the fighter id
     */
    public function fighter_form()
    {   //to delete after test
        //$this->_newAvatar($this->request->data['Fighter']['Avatar']);
        
        $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
        if(!empty($fighter)){
            $this->redirect(array('controller' => 'Arena', 'action' => 'fighter'));
        }else{
            if ($this-> request-> is ('post')){
                if($this->newAvatar($this->request->data['Fighter']['Avatar'])){
                    $success = $this->Fighter->newFighter( $this->Session->read('PlayerId'), $this->request->data['Fighter']['Name'] );
                    if($success=='true'){
                    $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
                    $this->Event->fighterEvent($fighter);

                    $this->redirect(array('controller' => 'Arena', 'action' => 'fighter'));
                    }else $this->Session->setFlash($success);
                }
                
            }
        }       
                 
    }
    
    
    protected function _newAvatar($image){
        
        $playerId = $this->Session->read('PlayerId');
        if($image){
            $type=explode('/', $image['type']);
            //check image type is png
            if($type[1]=='png' && $type[0]=='image'){
                //check image size is less than 1mo
                if($image['size']<1048576){
                    //name image with the playerId
                    $destination='avatars/'.$playerId.'.'.$type[1];
                    move_uploaded_file($image['tmp_name'], $destination);
                    return true;
                }else return false;
            }else return false;
        }else return false;
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
