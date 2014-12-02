<?php $this->assign('title', 'index');
$this->layout = 'bootstrap';
?>
<div class="row">
    <div class="col-md-2">
        
            <div  class="row text-danger">
                <!-- Carousel
                   ================================================== -->
                   <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ($img_list as $i => $img): ?>
                                      <?php
                                          if($i == 0){
                                              echo '<div class="item active">';
                                          }else{
                                              echo '<div class="item">';
                                          }
                                          echo $this->Html->image($img, ['alt' => 'CakePHP']);
                                          echo '</div>'
                                      ?>
                                <?php endforeach; ?> 
                            </div>
                           
                     </div>
            </div>
    </div>
    
    <div class="col-md-9 col-md-offset-1">
        <h1>Bienvenu <?php echo $myname;?> dans WebArena</h1>
    </div>
    
</div>


<div class="row">
    <div class="col-md-6">
        
        <div class="indexChart" id="chartdiv1" ></div>
    </div>
    
    <div class="col-md-6">
        
        <div class="indexChart" id="chartdiv2" ></div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-6">
        
        <div class="indexChart" id="chartdiv3" ></div>
    </div>
    
    <div class="col-md-6">
        
        <div class="indexChart" id="chartdiv4" ></div>
    </div>
    
</div>

<!--
<div  class="row text-danger">
    
    <div id="chartdiv1" style="height:400px;width:300px; "></div>
    <div id="chartdiv2" style="height:400px;width:300px; "></div>
    <div id="chartdiv3" style="height:400px;width:300px; "></div>
    <div id="chartdiv4" style="height:400px;width:300px; "></div>
    
    
</div>

-->


<?php 
    echo $this->Html->script('jquery.jqplot');
    echo $this->Html->script('excanvas');
    echo $this->Html->script('jqplot.dateAxisRenderer.min');
    echo $this->Html->script('jqplot.barRenderer');
    echo $this->Html->script('jqplot.categoryAxisRenderer');
    echo $this->Html->script('jqplot.dateAxisRenderer.min');
    echo $this->Html->script('jqplot.pieRenderer');
    echo $this->Html->script('jqplot.pointLabels');
    echo $this->Html->script('index'); 
    
?>

