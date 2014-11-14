<h1>Sight</h1>
<h2>Fighters</h2>
<div>
    <?php foreach ($fighters as $fighter): ?>
        <ul>
            <li>
                <p><?php echo $fighter["Fighter"]["name"]; ?><br>
                ( <?php echo $fighter["Fighter"]["coordinate_x"]; ?> , 
                <?php echo $fighter["Fighter"]["coordinate_y"]; ?> )
                </p>
            </li>
        </ul>

    <?php endforeach; ?>
</div>





<h2>Actions</h2>
<div>
<h2>Move</h2>
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
<h2>Attack</h2>
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

