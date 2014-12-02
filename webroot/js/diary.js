var last_update_date;
var table;
var time_before_message_erase = 5000;

$(function(){ 

    init_diary();
    
         
});


function init_diary(){
    
    $.ajax({
	       type: "POST",
	       url: "/WebArenaGoupSI1-04-BE/Diary/diaryInit",
               dataType: "json",
	       success: function(data){
                   console.log(data);
                   diary_table(data);
               },
	       error: function (error){
	       }
    });
    
}

function diary_table(data){
    
    table = $('#diary_table').DataTable( {
    data: data,
    columns: [
        { data: 'Date', title:'Date' },
        { data: 'Event',title:'Event' },
        { data: 'Position',title:'Position' }],
    scrollY: "400px",
    scrollX: false,
    scrollCollapse: true,
    paging:false,
    order: [[ 0, "desc" ]],
    oLanguage: {"sZeroRecords": "There is no event..."}
    
} );
    
    
    
}
















