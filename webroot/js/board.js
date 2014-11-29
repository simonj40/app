//old fighters list
var fighters0 = [];
//new fighters list
var fighters1 = [];
//Time before board refresh
var time_before_refresh = 0;
var time_before_message_erase = 5000;


$(function(){ 
    
    ajax_board();   
    
    
    $("[type='button']").on( "click", function() {
        var action = $(this).attr("action");
        if( action == 'move') move($(this).attr("value"));
        if( action == 'attack') attack($(this).attr("value"));
     });
     
     
           
});


function move(direction){

    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Board/move",
               data : { direction : direction},
               dataType: "text",
	       success: function(data){
                   message('#moveMessage',data);
               },
	       error: function (error){
	       }
    });
    
}

function attack(direction){

    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Board/attack",
               data : { direction : direction},
               dataType: "text",
	       success: function(data){
                   console.log(data);
                   message('#attackMessage',data);
               },
	       error: function (error){
	       }
    }); 
}


function message(id,message){  
    if(message.length){
        $(id).text(message);
        setTimeout(function() 
        {
           $(id).empty();
        }, time_before_message_erase);
    }
    
    
}


function update_board(data){
    //save the new fighters list
    fighters1 = data;
    //Initialise disconnected
    var disconnected = [];
    var isNew;
    if(fighters0.length>0){
        for(i=0;i<fighters0.length;i++){
            disconnected[i]=true;
        }
    }

    //for each fighter from the new list
    $.each(fighters1, function( index1, fighter1 ) {   
        isNew = true;
        //if the old list exists (not initialization)
        if(fighters0.length>0){ 
            //for each fighter from the old list
            $.each(fighters0, function( index0, fighter0 ) {
                //check if the fighter from the new list is the same as the fighter from the old list
                if( fighter1.player_id === fighter0.player_id ){
                    //this fighter is still connected an will be not removed from the board
                    disconnected[index0]=false;
                    //
                    isNew = false;
                    //check if the fighter's coordinates have changed
                    if(parseInt(fighter1.coordinate_x) !== parseInt(fighter0.coordinate_x)
                        || parseInt(fighter1.coordinate_y) !== parseInt(fighter0.coordinate_y) ){
                            //remove the avatar image from its old position
                            clean_board(fighter0);
                            //add the avatar image to its new position
                            set_avatar(fighter1);
                    }
                }
            }); 
            
            if(isNew) set_avatar(fighter1);
            
        //if the old fighter list doesn't exist yet
        }else{
            //Initialize the board with the player from the list
            set_avatar(fighter1);
        }
        
    });
    
    //remove the disconnected fighters from the board
    $.each(disconnected, function( index, d ) {
        if(d===true) clean_board(fighters0[index]);
    });
    
    //Set the old list with the fighters from the new list
    fighters0=data;
    
    //Ajax call again after t milliseconds
    setTimeout(function() 
        {
           ajax_board(); 
        }, time_before_refresh);
}
    
//Ajax call to the board method of the BoardController to update the board
function ajax_board(){
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Board/board",
               dataType: "json",
	       success: function(data){
                   update_board(data);
               },
	       error: function (error){
	       }
    }); 

}


//remove the fighter from the board
function clean_board(fighter){

        var x =fighter.coordinate_x;
        var y =fighter.coordinate_y;    
        var id = '#'+x+'_'+y;       
        $(id).empty();
}

//Set the avatar of the fighte on the board
function set_avatar(fighter){
    
    var x =fighter.coordinate_x;
    var y =fighter.coordinate_y;
    var id = '#'+x+'_'+y;
    var link ="/WebArenaGoupSI1-04-BE/img/avatars/"+fighter.player_id+".png";
    var img="<img src='"+link+"'>";
    $(id).html(img);
    
}









