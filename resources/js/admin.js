function datesBetween(startDt, endDt) {
    var between = [];
    var currentDate = new Date(startDt);
    var end = new Date(endDt);
    while (currentDate <= end) {
        between.push( $.datepicker.formatDate('mm/dd/yy',new Date(currentDate)) );
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return between;
}

var Ajax = {

    get: function (url, success, data = null, beforeSend = null) {

        $.ajax({

            cache: false,
            url: base_url + '/' + url,
            type: "GET",
            data: data,
            success: function(response){
                
            App[success](response);
                
            },
            beforeSend: function(){
               
            if(beforeSend)    
            App[beforeSend]();
                
            }

        });
    }

};

var App = {


    GetReservationData: function (id, calendar_id, date) {

        App.calendar_id = calendar_id;
        Ajax.get('ajaxGetReservationData?fromWebApp=1', 'AfterGetReservationData',{room_id: id, date: date},'BeforeGetReservationData');
        

    },
    BeforeGetReservationData: function() {
        
       
    $('.loader_' + App.calendar_id).hide();
    $('.hidden_' + App.calendar_id).show();
        
  
    },
    AfterGetReservationData: function(response) {
        
        
        $('.hidden_' + App.calendar_id + " .reservation_data_room_number").html(response.room_number);
        
        $('.hidden_' + App.calendar_id + " .reservation_data_day_in").html(response.day_in);
        $('.hidden_' + App.calendar_id + " .reservation_data_day_out").html(response.day_out);
        $('.hidden_' + App.calendar_id + " .reservation_data_person").html(response.FullName);
        $('.hidden_' + App.calendar_id + " .reservation_data_person").attr('href', response.userLink);
        $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").attr('href', response.deleteResLink);


        if (response.status)
        {
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('href');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('disabled', 'disabled');

        } else
        {
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('href', response.confirmResLink);
        }

    }
};

$(document).on('click', '.dropdown', function (e) {
    e.stopPropagation();
});