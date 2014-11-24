<?php $this->assign('title', 'diary');
$this->layout = 'bootstrap';
?>
<h1>Diary</h1>
<div>
    <?php foreach ($events as $event): ?>
        <ul>
            <li>
                <?php echo $event["Event"]["name"] ?> - 
                <?php echo $event["Event"]["date"] ?> - 
                ( <?php echo $event["Event"]["coordinate_x"] ?> , <?php echo $event["Event"]["coordinate_y"] ?> )                    
            </li>
        </ul>

    <?php endforeach; ?>
</div>