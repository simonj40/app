<?php

$this->assign('title', 'sight');
$this->layout = 'bootstrap';
?>
<h1>My Fighter</h1>
<div class="row text-danger">
    <h2>My Fighters:</h2>
   
    <div class="col-lg-4 col-md-offset-2">
        <p><span>Fighter name:<?php echo $fighter["Fighter"]["name"]; ?></span><br/>
            <span>Fighter level: <?php echo $fighter["Fighter"]["level"]; ?></span><br/>
            <span>Fighter position: ( <?php echo $fighter["Fighter"]["coordinate_x"]; ?> , 
                <?php echo $fighter["Fighter"]["coordinate_y"]; ?> )</span>           
    </div>                
</div>
<div class="row text-danger">
    
   <?php echo $this->Html->image($avatar, array('alt' => 'CakePHP')); ?>        
</div>

<div class="row text-danger">
    <h2>Upgrades:...</h2>
    <div class="col-lg-4 col-md-offset-2">
        
    </div>
</div>