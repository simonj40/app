
$(function(){ 
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Index/plot_events",
               dataType: "json",
	       success: function(data){            
                   draw_events_day(data);
               },
	       error: function (error){
	       }
    });
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Index/plot_fighters",
               dataType: "json",
	       success: function(data){            
                   draw_skills(data);
               },
	       error: function (error){
	       }
    });
});



function draw_skills(data){
    //draw strength per fighter
    var skill = strength_array(data);
    var names = fighter_name_array(data);
    draw_fighter_skill(skill, names, 'chartdiv2', 'Strenght per fighter');
    //draw xp per fighter
    skill = xp_array(data);
    names = fighter_name_array(data);
    draw_fighter_skill(skill, names, 'chartdiv3', 'Experience per fighter');
    //draw xp per fighter
    skill = health_array(data);
    names = fighter_name_array(data);
    draw_fighter_skill(skill, names, 'chartdiv4', 'Health per fighter');
}


function draw_events_day(data0){
    
    data = json_array(data0);
   var plot1 = $.jqplot('chartdiv1', [data], {
    title:'Events per day',
    axes:{xaxis:{renderer:$.jqplot.DateAxisRenderer}}
  });
    
}


function draw_fighter_skill(skill, names, id, title){
    var s1 = skill;
    var ticks = names;
       
    $.jqplot.config.enablePlugins = true;
      
        plot1 = $.jqplot(id, [s1], {
            title: title,
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
     
        $(id).bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
}

function xp_array(data){
    var array = [];
    $.each(data ,function(index,fighter){    
                var dot = parseInt(fighter.Fighter.xp);
                array.push(dot);  
            });
            return array;     
    
}



function strength_array(data){
    var array = [];
    $.each(data ,function(index,fighter){    
                var dot = parseInt(fighter.Fighter.skill_strength);
                array.push(dot);  
            });
            return array;     
    
}

function health_array(data){
    var array = [];
    $.each(data ,function(index,fighter){    
                var dot = parseInt(fighter.Fighter.current_health);
                array.push(dot);  
            });
            return array;
}

function fighter_name_array(data){
    
    var array = [];
    $.each(data ,function(index,fighter){    
                var dot = fighter.Fighter.name;
                array.push(dot);  
            });
            return array;
    
}

function json_array(dots){
        var array = [];
            $.each(dots ,function(index,value){    
                var dot = obj_converter(value);
                array.push(dot);  
            });
    return array;
}


function obj_converter(myObj){
 
    var key = Object.keys(myObj);
    var value = myObj[key]; 
    return [key[0],value];
}
    




