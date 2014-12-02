$(function(){
   
    loadFigterDetails();
    loadGuildInfo();
    
    
    $("#create_button").on( "click", function() {
        createGuild();
     });
    
}); 


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

//load guild info
function loadGuildInfo(){
   $.ajax({
	       type: "GET",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/checkUserInGuild",
               dataType: "text",
               success: function (data) {   
                   if(data == '1'){
                       retrievePlayerGuild();
                   }else{
                      retrieveGuilds();                        
                   }                 
               },
	       error: function (error){
                   alert('errorx');
	       }
    });
    
}

//ajax call to retrieve all guilds
function retrievePlayerGuild(){
    $('#create_guild').hide();
    $.ajax({
	       type: "GET",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/retrievePlayersGuild",
               contentType: "application/json",
               dataType: "json",
               success: function (data) {   
                  
                   //populate HTML ul with list of guilds
                    $("#guildTable").empty();
                    //$("#listAllGuilds").children().remove();
                    $("#guildTable").append('<tr><td>' + data.Guild.name + '</td><td><button onclick="leave_guil();">' + "Leave Guild" + '</button></td></tr>');                                               
               },
	       error: function (error){
	       }
    }); 
}


//ajax call to retrieve all guilds
function retrieveGuilds(){
    $('#create_guild').show();
    
    $.ajax({
	       type: "GET",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/retrieveAllGuilds",
               contentType: "application/json",
               dataType: "json",
               success: function (data) {            
                   $("#guildTable").empty();
                   //populate HTML ul with list of guilds
                   $.each(data, function(key,value) {
                            
                            //$("#listAllGuilds").children().remove();
                            $("#guildTable").append('<tr><td>' + value.Guild.name + '</td><td><button onclick="join_guil('+value.Guild.id+');">' + "Join Guild" + '</button></td></tr>');
                            });                                                                       
               },
	       error: function (error){
	       }
    }); 
}


function leave_guil(){
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/leaveGuild",
               dataType: "text",
	       success: function(data){
                   loadGuildInfo();
               },
	       error: function (error){
	       }
    });
    
}

function join_guil(guild){
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/joinGuild",
               data:{guildId:guild},
               dataType: "text",
	       success: function(data){
                   loadGuildInfo();
               },
	       error: function (error){
	       }
    });
    
}
   
    
function createGuild(){
    
    var name = $('#guild_name').val();
    
    if(name != ''){
        $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Upgrade/createGuild",
               data:{name:name},
               dataType: "text",
	       success: function(data){
                   
                   loadGuildInfo();
               },
	       error: function (error){
	       }
    });
    }
    
    
    
    
    
    
}    
    

    
    
    
    
    

