<?php

$this->assign('title', 'sight');
$this->layout = 'bootstrap';
?>
<h1>Sight</h1>
<div class="row text-danger">
   
    <div class="col-md-3" >
        <div class="row">
         <h2>My Fighter:</h2> 
        <p><span>Fighter name:<?php echo $fighter["Fighter"]["name"]; ?></span><br/>
            <span>Fighter level: <?php echo $fighter["Fighter"]["level"]; ?></span><br/>
            <span>Fighter position: ( <?php echo $fighter["Fighter"]["coordinate_x"]; ?> , 
                <?php echo $fighter["Fighter"]["coordinate_y"]; ?> )</span>   </div>  
        <div class="row"> <h2>Actions:</h2>
        <h3>Move</h3>
        <form id="moveFighterForm" method="post" action="sight" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="move">In which direction would you like to move :</label>
                <select name="Fightermove" class="form-control">
                    <option value=""></option>
                    <option value="north">North</option>
                    <option value="south">South</option>
                    <option value="west">West</option>
                    <option value="east">East</option>
                </select>
            </div>            
                <button type="submit" class="btn btn-primary btn-lg">Send</button>
        </form></div>
         <div class="row ">  <h3>Attack</h3>
        <form id="attackForm" method="post" action="sight" class="form-horizontal" role="form">
            <div class="form-group">
            <label for="attack">In which direction would you like to attack :</label>
            <select name="Fighterattack" class="form-control">
                <option value=""></option>
                <option value="north">North</option>
                <option value="south">South</option>
                <option value="west">West</option>
                <option value="east">East</option>
            </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg" >Send</button>
        </form></div>
    </div>                
 <div class="col-md-9">
    <h2>Board Game:</h2> 
    <div>
        <table>
           
               
                   <?php  for($i=0; $i<10; $i++){echo "<tr></tr>";
                     for($j=0; $j<15;$j++){ echo "<td></td>";  }} ?>
                  
             
        </table>
    </div>     
 </div>
</div>




