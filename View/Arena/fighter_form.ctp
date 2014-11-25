<?php
$this->assign('title', 'new fighter');
$this->layout = 'bootstrap';
?>

<div class="row">
     <h1>New Fighter</h1>
    
       
<?php
//create a fighter
echo $this->Form->create('Fighter', array('role'=>'form', 'class'=>'form-horizontal'));
echo "<div class='col-lg-5'>";
//echo $this->Form->input("id", array('div'=>'form-group', 'class'=>'form-control'));
echo $this->Form->input("Name", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("Player", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("coordinate_x", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("coordinate_y", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("level", array('div'=>'form-group', 'class'=>'form-control'));
//split form into two so as to take up less space on the page
echo $this->Form->input("Avatar", array('div'=>'form-group', 'class'=>'form-control', 'type'=>'file'));
echo $this->Form->button('Create', array('class'=>'btn btn-primary btn-lg'));
echo $this->Form->end();
echo "</div><div class='col-lg-5 col-md-offset-2'>";

//echo $this->Form->input("xp", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("skill_sight", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("skill_strength", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("skill_health", array('div'=>'form-group', 'class'=>'form-control'));
//echo $this->Form->input("current_health", array('div'=>'form-group', 'class'=>'form-control'));
echo "</div>";
?>
    
</div>