<?php 

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController
{
    
    public $uses = array('Player', 'Fighter', 'Event','Message');
    
    
    public function beforeFilter(){
        
        $login = $this->Session->read('Connected');
        $method = $this->request->params['action'];   

        if($login==NULL && $method!='login' && $method!='signin' && $method!='forgot' && $method!='recover'){
            $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
        }
        
    }
    
    /**
     * 
     */
    public function messages()
    {   
        
        $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
        if(!empty($fighter)){
            //$events=$this->Event->diary();
            //$this->set('events',$events);  

            $fighters = $this->Fighter->find('all');
            $this->set('fighters',$fighters);

            $playerId = $this->Session->read('PlayerId');  
            $fighter = $this->Fighter->findPlayersFighter($playerId);
            $fighterId=$fighter['Fighter']['id'];
            $this->set('fighterId', $fighterId);
        }else $this->redirect(array('controller' => 'Arena', 'action' => 'fighterForm'));
        
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
        $playerId = $this->Session->read('PlayerId');
        $avatar = 'avatars/'.$playerId.'.png';
        $avatar_default = 'avatars/default/1.png';
        
        if(file_exists(WWW_ROOT.'img/'.$avatar)){
            $this->set('avatar',$avatar);
        }else{
            $this->set('avatar',$avatar_default);
        }
                
        $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
        $fighters = $this->Fighter->find('all');
        $this->set('fighters',$fighters);
        
       
        //retrieve last 24h messages
        $time = time() - 3600*24;
        $date = date('Y-m-d H:i:s', $time);
        $conditions = array(
            "date >" => $date,
                );
        $messages = $this->Message->find('all', array('conditions' => $conditions));
        
        $this->set('messages', $messages);
        
        if(!empty($fighter)){
            $fighterId=$fighter['Fighter']['id'];
            $this->set('fighterId', $fighterId);
        }else $this->redirect(array('controller' => 'Arena', 'action' => 'fighterForm'));

    }
    
    
    
    
    
    /**
     *@todo implement level upgrade adn skills etc ...
     */
    public function fighter()
    {    
        $success = '';
        $playerId = $this->Session->read('PlayerId');
        $fighter = $this->Fighter->findPlayersFighter($playerId);

        if(!empty($fighter)){
            if($this-> request-> is ('post')){
                $image = $this->request->data['Fighter']['Avatar'];      
                $success = $this->_change_avatar($image);
                
            } 
            $this->set('fighter',$fighter);
            $this->set('upload_success',$success);
            $avatar = 'avatars/'.$playerId.'.png';
            $avatar_default = 'avatars/default/1.png';
            
            if(file_exists(WWW_ROOT.'img/'.$avatar)){
            $this->set('avatar',$avatar);
            }else{
                $this->set('avatar',$avatar_default);
            }
            
        }else{
            $this->redirect(array('controller' => 'Arena', 'action' => 'fighterForm'));
        }

    }
    
        
    protected function _change_avatar($image){

        if($image['error']==0){
                    //check if image format fits
                   if($image['size']<1048576 && $image['type']=='image/png'){
                       //set real avatar
                       $this->_newAvatar($image);
                       $success = 'Your avatar has been changed !';
                   }else{
                       $this->_defaulftAvatar();
                       $success = "Avatar invalid, you've been assigned a default avatar !";
                   }
        }else{
            $this->_defaulftAvatar();
            $success = "Avatar invalid, you've been assigned a default avatar !";
        }
        
        return $success;
    }
    
    
    
    /**
     * @todo Implement the Avavtar download and file namng with the fighter id
     */
    public function fighterForm()
    {   
        $playerId = $this->Session->read('PlayerId');
        $fighter = $this->Fighter->findPlayersFighter($playerId);
        
        if(!empty($fighter)){
            $this->redirect(array('controller' => 'Arena', 'action' => 'fighter'));
        }else if($this-> request-> is ('post')){
            
            $name = $this->request->data['Fighter']['Name'];
            $image = $this->request->data['Fighter']['Avatar'];
            //check if fighter name exists 
            if(!$this->Fighter->nameExist($name) && $name!=''){
                //check is avatar field is not empty
                //Create fighter
                $this->Fighter->newFighter($playerId, $name);
                //Create avatar
                $this->_newAvatar($image);
                //Create Event
                $fighter = $this->Fighter->findPlayersFighter($this->Session->read('PlayerId'));
                $this->Event->fighterEvent($fighter);
                
                if($image['error']==0){
                    //check if image format fits
                   if($image['size']<1048576 && $image['type']=='image/png'){
                       //set real avatar
                       $this->_newAvatar($image);
                   }else{
                       $this->_defaulftAvatar();
                   }
                }else{
                    $this->_defaulftAvatar();
                }
  
                //redirect to fighter page
                $this->redirect(array('controller' => 'Arena', 'action' => 'fighter'));
                
            }else $this->Session->setFlash('Fighter with the name '.$name.' already exists');   
        }
    }
    

    

    
    protected function _newAvatar($image){
        
        $playerId = $this->Session->read('PlayerId');
        $destination='img/avatars/'.$playerId.'.png';
        move_uploaded_file($image['tmp_name'], $destination);
        
    } 
    
    
    protected function _defaulftAvatar(){
        
        $playerId = $this->Session->read('PlayerId');
        $destination='img/avatars/'.$playerId.'.png';
        $no = rand(1, 6);
        $source = 'img/avatars/default/'.$no.'.png';
        copy($source, $destination);
        
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
