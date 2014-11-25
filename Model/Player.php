<?php

App::uses('AppModel', 'Model');
App::uses('Security','Utility');
App::uses('CakeEmail', 'Network/Email');


class Player extends AppModel {
    
    public function createNew($email){
        if(!$this->exist($email)){
            //generate and encrypt password
            $password=  $this->generatePassword(5);
            $passwordX = Security::hash($password, 'md5', 'my-salt');
            //create new user
            $this->create();
            $this->set(array(
            'email' => $email,
            'password' => $passwordX
            ));
        $this->save(); 
        
        //Send E-mail with password
        $Email = new CakeEmail();
        $Email->from(array('admin@Arena.com' => 'Arena'));
        $Email->to($email);
        $Email->subject('Your Subscription');
        $Email->send($password);
        return 'An Email containing your password has been sent to you !';
        }else return 'Player already exists !';
    }

    public function exist($email){    
        $condition=array(
            'email'=>$email
                ); 

        $player=$this->find( 'first', array( 'conditions' => $condition ));
        
        if (empty($player)) return false;
        else return true;        
    }
    
    public function findPlayer($email){    
        $condition=array(
            'email'=>$email
                ); 

        $player=$this->find( 'first', array( 'conditions' => $condition ));
        
        if (empty($player)) return NULL;
        else return $player;        
    }
    
   
    
    public function checkLogin($login,$password){
        $condition=array(
            'email'=>$login
        ); 
        
        $player=$this->find( 'first', array( 'conditions' => $condition ));
        
        if(!empty($player)){ 
            $passwordDB=$player['Player']['password'];
            $password = Security::hash($password, 'md5', 'my-salt');
            if($passwordDB==$password) return true;
            else return false;
        }else return false;  
    }
    
        public function checkPassword($login,$password){
        $condition=array(
            'email'=>$login
        ); 
        
        $player=$this->find( 'first', array( 'conditions' => $condition ));
        
        if(!empty($player)){ 
            $passwordDB=$player['Player']['password'];
            if($passwordDB==$password) return true;
            else return false;
        }else return false;  
    }
    
    public function generatePassword ($length){ 
        // inicializa variables 
        $password = ""; 
        $i = 0; 
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";  
         
        // agrega random 
        while ($i < $length){ 
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
             
            if (!strstr($password, $char)) {  
                $password .= $char; 
                $i++; 
            } 
        } 
        return $password; 
    } 
    
    
    public function recover($email, $password, $newPassword){
        
        $condition=array(
            'email'=>$email
                ); 

        $player=$this->find( 'first', array( 'conditions' => $condition ));

        if($player['Player']['password']==$password){
            $this->read(null,$player['Player']['id']);     
            $newPassword = Security::hash($newPassword, 'md5', 'my-salt');
            $this->set('password', $newPassword);
            $this->save();
            return true;
        }
        return false;
    }
    

}