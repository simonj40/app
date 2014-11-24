<?php

$this->assign('title', 'sight');
$this->layout = 'bootstrap';
?>
<h1>Sight</h1>
<div class="row text-danger">
    <h2>Fighters:</h2>

    <?php foreach ($fighters as $fighter): ?>     
    <div class="col-lg-4 col-md-offset-2">
        <p><span>Fighter name:<?php echo $fighter["Fighter"]["name"]; ?></span><br/>
            <span>Fighter level: <?php echo $fighter["Fighter"]["level"]; ?></span><br/>
            <span>Fighter position: ( <?php echo $fighter["Fighter"]["coordinate_x"]; ?> , 
                <?php echo $fighter["Fighter"]["coordinate_y"]; ?> )</span>           
    </div>                
    <?php endforeach; ?>
</div>

<div class="row text-danger">
    <h2>Actions:</h2>
    <div class="col-lg-4 col-md-offset-2">
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
        </form>
    </div>
    <div class="col-lg-4 col-md-offset-2">
        <h3>Attack</h3>
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
            <button type="submit" class="btn btn-primary btn-lg">Send</button>
        </form>
    </div>
</div>

