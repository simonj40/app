<?php
    $this->assign('title', 'sight');
    $this->layout = 'bootstrap';
    echo $this->Html->script('board'); 
?>
<h1>Sight</h1>
<div class="row text-danger">
   
    <div class="col-md-3" >
        <div class="row">
            <table class="table" id="myFighter" fighterId ="<?php echo $fighterId; ?>">
            <tr><th colspan="2"><?php echo $this->Html->image($avatar, array('alt' => 'CakePHP')); ?></th><th><span class="label label-danger" id='fighter_name'></span></th></tr>
                <tr>
                    <td><span class="label label-default">Sight</span></td>
                    <td id="fighter_sight"></td> 
                </tr>
                <tr>
                    <td><span class="label label-primary">Strength</span></td>
                    <td id="fighter_strength"></td>
                </tr>
                <tr>
                    <td><span class="label label-success">Health</span></td>
                    <td id="fighter_c_health"></td>
                </tr>
                <tr>
                    <td><span class="label label-success">Skill Health</span></td>
                    <td id="fighter_health"></td>
                </tr>
                 <tr>
                     <td><span class="label label-info">XP Points</span></td>
                    <td id="fighter_xp"></td>
                    <td></td>
                </tr>
                 <tr>
                     <td><span class="label label-info">Unused XP</span></td>
                    <td id="fighter_xp_unused"></td>
                    <td></td>
                </tr>
                 <tr>
                     <td><span class="label label-info">Level</span></td>
                    <td id="fighter_level"><span id='fighter_level'></span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><span class="label label-warning">Position</span></td>
                    <td id="fighter_position"> </td>
                    <td></td>
                </tr>

            </table>  
            
            
            <!--
            <h2>My Fighter:</h2> 
            <div id="myFighter" fighterId ="<?php echo $fighterId; ?>">
                <ul>
                    <li>Name : <span id='fighter_name'></span></li>
                    <li>Guild : <span id='fighter_guild'></span></li>
                    <li>Level : <span id='fighter_level'></span></li>
                    <li>Experience : fighter_xp</li>
                    <li>Current Health : <span id='fighter_c_health'></span></li>
                    <li>Health Skill : <span id='fighter_health'></span></li>
                    <li>Sight Skill : <span id='fighter_sight'></span></li>
                    <li>Strength Skill : <span id='fighter_strength'></span></li>
                </ul>
            </div>
            -->
        </div>  
        <div class="row"> 
            <h2>Actions:</h2>
   
            
        <h3>Move</h3>
        <div id="moveMessage">&nbsp;</div>
        <div class="btn" role="group">
            <div><button type="button" action="move" class="btn btn-default" value='north' >North</button></div>
            <button type="button" action="move" class="btn btn-default" value='west' >West</button>
            <button type="button" action="move" class="btn btn-default" value='east' >East</button>
            <div><button type="button" action="move" class="btn btn-default" value='south' >South</button></div>
        </div>

        </div>
         <div class="row">  
             <h3>Attack</h3>
             <div id="attackMessage">&nbsp;</div>
            <div class="btn" role="group">
                <div><button type="button" action="attack" class="btn btn-default" value='north' >North</button></div>
                <button type="button" action="attack" class="btn btn-default" value='west' >West</button>
                <button type="button" action="attack" class="btn btn-default" value='east' >East</button>
                <div><button type="button" action="attack" class="btn btn-default" value='south' >South</button></div>
            </div>
        </div>
        <div class="row"> 
            
             <h3>Yell</h3>
             <div id="yellMessage">&nbsp;</div>
             <form class="form-horizontal">
                <fieldset>
                <!-- Text input-->
                <div class="form-group">  
                  <div class="">
                  <input id="yell_text" name="textinput" type="text" placeholder="My Yell" class="form-control input-md">
                  </div>
                </div>

                <!-- Button -->
                <div class="form-group">  
                  <div class="">
                    <button type="button" name="singlebutton" class="btn btn-primary" action="yell">Yell !</button>
                  </div>
                </div>

                </fieldset>
            </form>

        </div>
</div>              
 <div class="col-md-9">
    <h2>Board Game :  <span class="label label-danger" id='attack_alert'></span></h2> 
    
    <div id='boardDiv'>
        <table id='boardTable'>
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




