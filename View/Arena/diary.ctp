<?php $this->assign('title', 'diary');?>
<h2>Diary</h2>
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