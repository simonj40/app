
$(function(){ 
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Index/plot",
               dataType: "json",
	       success: function(data){
                   console.log(data);
                   draw(data);
               },
	       error: function (error){
	       }
    });
      
    
    
    
    
    
});


function draw(data){
    
   $.jqplot('chartdiv',  data,
   { title:'square Line',
  axes:{yaxis:{renderer: $.jqplot.LogAxisRenderer, tickDistribution:'power'}},
  series:[{color:'#5FAB78'}]}
    
    
    );

       
}







