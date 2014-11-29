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
            <div id="myFighter" fighterId ="<?php echo $fighterId; ?>">
                <ul>
                    <li>Name : <span id='fighter_name'></span></li>
                    <li>Guild : <span id='fighter_guild'></span></li>
                    <li>Level : <span id='fighter_level'></span></li>
                    <li>Experience : <span id='fighter_xp'></span></li>
                    <li>Current Health : <span id='fighter_c_health'></span></li>
                    <li>Health Skill : <span id='fighter_health'></span></li>
                    <li>Sight Skill : <span id='fighter_sight'></span></li>
                    <li>Strength Skill : <span id='fighter_strength'></span></li>
                </ul>
   
            </div>
 
        </div>  
        <div class="row"> <h2>Actions:</h2>
        <h3>Move</h3>
        <div id='moveMessage'></div>
        <div class="btn" role="group">
            <div><button type="button" action="move" class="btn btn-default" value='north' >North</button></div>
            <button type="button" action="move" class="btn btn-default" value='west' >West</button>
            <button type="button" action="move" class="btn btn-default" value='east' >East</button>
            <div><button type="button" action="move" class="btn btn-default" value='south' >South</button></div>
        </div>

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

        </div>
    </div>                
 <div class="col-md-9">
    <h2>Board Game:</h2> 
    <div id='boardTable'>
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




