<?php
$this->assign('title', 'fighter');
$this->layout = 'bootstrap';
?>

<div class="row">
     <h1>Subscribe</h1>
    
       
<?php
//Subscribe
echo $this->Form->create('Subscribe', array('role'=>'form', 'class'=>'form-horizontal'));
echo "<div class='col-lg-5'>";
echo $this->Form->input("Email", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("Password", array('div'=>'form-group', 'class'=>'form-control'));
//split form into two so as to take up less space on the page
echo "</div><div class='col-lg-5 col-md-offset-2'>";
echo $this->Form->button('Subscribe', array('class'=>'btn btn-primary btn-lg'));
echo $this->Form->end();
echo "</div>";
?>
    
</div>