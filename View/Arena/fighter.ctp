<?php

$this->assign('title', 'sight');
$this->layout = 'bootstrap';
$this->Html->script('fighter', array('block' => 'scriptBottom'));
?>
<h2>My Fighter</h2>
<hr>

<div class="row">
    <div class="col-md-3">
        <div class="row">
        <table class="table">
            <tr><th colspan="2"><?php echo $this->Html->image($avatar, array('alt' => 'CakePHP')); ?></th><th><span class="label label-danger"><?php echo $fighter["Fighter"]["name"]; ?></span></th></tr>
        <tr>
            <td><span class="label label-default">Sight</span></td>
            <td id="skillSightCell"></td> 
            <td><button class="btn btn-default btn-sm badge" onClick="upgradeSkillLevel('view');">+</button></td>
        </tr>
        <tr>
            <td><span class="label label-primary">Strength</span></td>
            <td id="skillStrengthCell"></td>
            <td><button class="btn btn-default btn-sm badge" onClick="upgradeSkillLevel('strength');">+</button></td>
        </tr>
        <tr>
            <td><span class="label label-success">Health</span></td>
            <td id="skillHealthCell"></td>
            <td><button class="btn btn-default btn-sm badge" onClick="upgradeSkillLevel('lifepoints');">+</button></td>
        </tr>
        <tr>
            <td><span class="label label-success">Skill Health</span></td>
            <td id="skillHealthCell2"></td>
        </tr>
         <tr>
             <td><span class="label label-info">XP Points</span></td>
            <td id="fighterXPCell"></td>
            <td></td>
        </tr>
         <tr>
             <td><span class="label label-info">Unused XP</span></td>
            <td id="unusedXPCell"></td>
            <td></td>
        </tr>
         <tr>
             <td><span class="label label-info">Level</span></td>
            <td id="fighterLevelCell"></td>
            <td></td>
        </tr>
        <tr>
            <td><span class="label label-warning">Position</span></td>
            <td id="fighterPositionCell"> </td>
            <td></td>
        </tr>
        
    </table>  
  </div>
        <div class='row'>
            <?php
            echo $this->Form->create('Fighter', array('role'=>'form', 'class'=>'form-horizontal' , 'enctype'=>'multipart/form-data'));
            echo $this->Form->input("Avatar", array('div'=>'form-group', 'class'=>'form-control', 'type'=>'file'));
            echo $this->Form->button('Create', array('class'=>'btn btn-primary btn-lg'));
            echo $this->Form->end();
            ?>
            <div><?php echo $upload_success; ?></div>
        </div>
        
    </div>
    <div class="col-md-8 col-md-offset-1">
        <p>For Guild Option</p>
        <table class="table">
            <thead>
            <th>Guild Name(s)</th><th></th>
            </thead>
            <tbody id="guildTable">                
            </tbody>
        </table>
        <div class='row' id='create_guild'>
            
            <div class="col-lg-8">
                <div class="input-group">
                  <span class="input-group-btn">                
                      <button  class="btn btn-primary" id="create_button">Create Guild</button>            
                  </span>
                    <input id="guild_name" type="text" placeholder="Guild name" class="form-control input-md">
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div>
    </div>                                    
</div>


