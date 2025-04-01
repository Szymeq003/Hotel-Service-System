var eventDates = {};
var datesConfirmed = ['02/12/2019', '02/15/2019', '02/23/2019'];
var datesnotConfirmed = ['02/13/2019', '02/14/2019', '02/20/2019', '02/21/2019'];



for (var i = 0; i < datesConfirmed.length; i++)
{
    eventDates[ datesConfirmed[i] ] = 'confirmed';
}

var tmp = {};
for (var i = 0; i < datesnotConfirmed.length; i++)
{
    tmp[ datesnotConfirmed[i] ] = 'notconfirmed';
}


Object.assign(eventDates, tmp);


$(function () {
    $(".reservation_calendar").datepicker({
        onSelect: function (data) {

            var a = $(this).attr('id');

            $('.hidden_' + a).hide();
            $('.loader_' + a).show();

            setTimeout(function () {

                $('.loader_' + a).hide();
                $('.hidden_' + a).show();

            }, 1000);

        },
        beforeShowDay: function (date)
        {
            var tmp = eventDates[ $.datepicker.formatDate('mm/dd/yy', date)];
//            console.log(tmp);
            if (tmp)
            {
                if (tmp == 'confirmed')
                    return [true, 'reservationconfirmed'];
                else
                    return [true, 'reservationnotconfirmed'];
            } else
                return [false, ''];

        }


    });
});
