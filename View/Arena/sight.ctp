<h2>Sight</h2>
<h3>Fighters</h3>
<div>
    <?php foreach ($fighters as $fighter): ?>
                 <p><span>Fighter name:<?php echo $fighter["Fighter"]["name"]; ?></span><br/>
                    <span>Fighter level: <?php echo $fighter["Fighter"]["level"]; ?></span><br/>
                    <span>Fighter position: ( <?php echo $fighter["Fighter"]["coordinate_x"]; ?> , 
                <?php echo $fighter["Fighter"]["coordinate_y"]; ?> )</span>                
                
    <?php endforeach; ?>
</div>

<h3>Actions</h3>
<div>
<h4>Move</h4>
<form id="moveFighterForm" method="post" action="sight">
    <label for="move">In which direction would you like to move :</label>
    <select name="Fightermove">
        <option value=""></option>
        <option value="north">North</option>
        <option value="south">South</option>
        <option value="west">West</option>
        <option value="east">East</option>
    </select>
    <input type="submit" value="Send" />
</form>
<h4>Attack</h4>
<form id="attackForm" method="post" action="sight">
    <label for="attack">In which direction would you like to attack :</label>
    <select name="Fighterattack">
        <option value=""></option>
        <option value="north">North</option>
        <option value="south">South</option>
        <option value="west">West</option>
        <option value="east">East</option>
    </select>
    <input type="submit" value="Send" />
</form>
</div>

