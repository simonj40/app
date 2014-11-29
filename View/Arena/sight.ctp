<?php
    $this->assign('title', 'sight');
    $this->layout = 'bootstrap';
    echo $this->Html->script('board');
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
        <div id='moveMessage'></div>
        <div class="btn" role="group">
            <div><button type="button" action="move" class="btn btn-default" value='north' >North</button></div>
            <button type="button" action="move" class="btn btn-default" value='west' >West</button>
            <button type="button" action="move" class="btn btn-default" value='east' >East</button>
            <div><button type="button" action="move" class="btn btn-default" value='south' >South</button></div>
        </div>

        
        
        <!--
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
        </form>
        -->
        </div>
         <div class="row ">  
             <h3>Attack</h3>
             
             <div id='attackMessage'></div>
            <div class="btn" role="group">
                <div><button type="button" action="attack" class="btn btn-default" value='north' >North</button></div>
                <button type="button" action="attack" class="btn btn-default" value='west' >West</button>
                <button type="button" action="attack" class="btn btn-default" value='east' >East</button>
                <div><button type="button" action="attack" class="btn btn-default" value='south' >South</button></div>
            </div>
             
             
             
        <!--     
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
        </form>
        -->
        </div>
    </div>                
 <div class="col-md-9">
    <h2>Board Game:</h2> 
    <div>
        <table>
           
               
                   <?php  
                   
                        for($j=9; $j>=0; $j--){
                            echo "<tr></tr>";
                            for($i=0; $i<15;$i++){      
                                $id = $i.'_'.$j;
                                echo "<td id='".$id."'></td>";  
                            } 
                        } 
                     
                    ?>
                  
             
        </table>
    </div>     
 </div>
</div>




