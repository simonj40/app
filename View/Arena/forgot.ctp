<?php

$this->assign('title', 'login');
$this->layout = 'bootstrap';
?>
<div class="row">
    <h1>Forgot your Password ?</h1>
    <div class="col-lg-6">        
<?php
echo $this->Form->create('Forgot', array('role'=>'form', 'class'=>'form-horizontal'));
echo $this->Form->input("Email", array('div'=>'form-group', 'class'=>'form-control'));
echo $this->Form->button('I Forgot My Password', array('class'=>'btn btn-primary btn-lg'));
echo $this->Form->end();
?>
    </div>
</div>