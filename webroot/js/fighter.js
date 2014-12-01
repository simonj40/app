loadFigterDetails();
//Ajax fucntion to retrieve fighter details
function loadFigterDetails(){
    $.ajax({
            type: "GET",
            url: "/WebArenaGoupSI1-04-BE/Upgrade/retrieveLevelSkills",
            contentType: "application/json",
            dataType: "json",
            success: function (data) {
                        $("#skillSightCell").empty();
                        $("#skillStrengthCell").empty();
                        $("#skillHealthCell").empty();
                        $("#fighterLevelCell").empty();
                        $("#fighterPositionCell").empty();
                        $("#fighterXPCell").empty();
                        $("#skillHealthCell2").empty();
                        $("#unusedXPCell").empty();
                        $("#skillSightCell").append('<kbd>' + data.skill_sight + '</kbd>');
                        $("#skillStrengthCell").append('<kbd>' + data.skill_strength + '</kbd>'); 
                        $("#skillHealthCell").append('<kbd>' + data.current_health + '</kbd>');
                        $("#fighterLevelCell").append('<kbd>' + data.level + '</kbd>');
                        $("#fighterPositionCell").append('<kbd>' + data.current_position_x + "," + data.current_position_x  + '</kbd>');
                        $("#fighterXPCell").append('<kbd>' + data.xp + '</kbd>');
                        $("#skillHealthCell2").append('<kbd>' + data.skill_health + '</kbd>');
                        $("#unusedXPCell").append('<kbd>' + data.unusedXP + '</kbd>');
                         },
            error: function (error) {
               alert('booooo');
            }
        });
        //Ends Here
}


//ajax call to update skill levels
function upgradeSkillLevel(skill){
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/updateLevelSkills",
               data : { skillToUpgrade : skill},
               dataType: "text",
	       success: function(data){
                   //reload details
                   loadFigterDetails();  
                   alert(data);
               },
	       error: function (error){
	       }
    });
    
  
}
