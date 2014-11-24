<?php

$this->assign('title', 'recovery');
$this->layout = 'bootstrap';
?>
<div class="row">
    <h1>Choose Your New Password</h1>
    <div class="col-lg-6">        
<?php




echo $this->Form->create('Recover', array('role'=>'form', 'class'=>'form-horizontal'));
echo $this->Form->hidden("Email", array('div'=>'form-group', 'class'=>'form-control', 'value'=>$email));
echo $this->Form->hidden("Password", array('div'=>'form-group', 'class'=>'form-control', 'value'=>$password));
echo $this->Form->input("New Password", array('div'=>'form-group', 'class'=>'form-control', 'type'=>'password'));
echo $this->Form->button('Change My Password', array('class'=>'btn btn-primary btn-lg'));
echo $this->Form->end();
?>
        <a href='#'>Forgot your password?</a>
    </div>
</div>