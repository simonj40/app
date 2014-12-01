var last_update_date;
var table;
var time_before_message_erase = 5000;

$(function(){ 

    init_messages();
    
    $("[type='button']").on( "click", function() {
        var action = $(this).attr("action");
        if( action == 'send') send_message();
        if( action == 'refresh') refresh_message();
        
        
     });
      
         
});


function refresh_message(){
    console.log(last_update_date);
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Messages/message_refresh",
               data:{date : last_update_date},
               dataType: "json",
	       success: function(data){
                        last_update_date = current_date();
                        console.log(data);
                        add_messages(data);
               },
	       error: function (error){
	       }
    });

}


function add_messages(data){
    
    $.each(data, function( index, message ) {
        table.row.add(message);
    });
    
    table.draw();

}

function current_date(){
    var date_js= new Date();
    var month = date_js.getMonth()+1;
    
    var date = date_js.getFullYear()+'-'+month+'-'+date_js.getDate()+' '
            +date_js.getHours()+':'+date_js.getMinutes()+':'+date_js.getSeconds();
    
    return date;
}


function init_messages(){
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Messages/messages_init",
               dataType: "json",
	       success: function(data){
                   
                   last_update_date = current_date();
                   messages_table(data);
                   
               },
	       error: function (error){
	       }
    });
    
}

function messages_table(data){
    
    table = $('#messagesTable').DataTable( {
    data: data,
    columns: [
        { data: 'Date', title:'Date' },
        { data: 'From',title:'From' },
        { data: 'To',title:'To' },
        { data: 'Title',title:'Title' },
        { data: 'Message',title:'Message', 'sortable': false }],
    scrollY: "400px",
    scrollX: false,
    scrollCollapse: true,
    paging:false,
    order: [[ 0, "desc" ]],
    oLanguage: {"sZeroRecords": "You've no message..."}
    
} );
    
    
    
}

function send_message(){
    
    var fighterTo = $('#fighters_select option:selected').attr('value');
    var title = $('#message_title').val();
    var message = $('#message_text').val();
    
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Messages/message",
               data : { fighterTo : fighterTo, title : title, message : message},
               dataType: "text",
	       success: function(data){
                   notification("Message Sent !");
               },
	       error: function (error){
	       }
    });
    
  
}

function notification(message){  
    if(message.length){
        $('#send_notification').text(message);
        setTimeout(function() 
        {
           $('#send_notification').empty();
        }, time_before_message_erase);
    }
    
    
}














