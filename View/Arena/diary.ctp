<?php $this->assign('title', 'diary');
    $this->layout = 'bootstrap';
?>

<h1>Diary</h1>
<div id='diary_box'>
    
    <table id='diary_table'>
        
    </table>
</div>

<?php
    echo $this->Html->script('diary');
?>