<?php

$this->assign('title', 'login');
$this->layout = 'bootstrap';
?>
<div class="row">
    <h1>Login</h1>
    <div class="col-lg-6">        
<?php
echo $this->Form->create('Login', array('role'=>'form', 'class'=>'form-horizontal'));
echo $this->Form->input("Email", array('div'=>'form-group', 'class'=>'form-control'));
echo $this->Form->input("Password", array('div'=>'form-group', 'class'=>'form-control', 'type'=>'password'));
echo $this->Form->button('Connexion', array('class'=>'btn btn-primary btn-lg'));
echo $this->Form->end();
?>
        <?php echo $this->Html->link('I forgot my password', array('controller' => 'Arena', 'action' => 'forgot')); ?>

    </div>
</div>