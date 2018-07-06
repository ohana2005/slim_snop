/**
 * Created by alexradyuk on 6/25/18.
 */

var SnopBooking = {
    init_search: function(){
        var today, tomorrow;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        tomorrow = new Date(new Date().getFullYear() + 1, new Date().getMonth(), new Date().getDate());
        var format = 'dd.mm.yyyy';
        $('#snop_arrival_date').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today,
            maxDate: tomorrow,
            format: format
        });
        $('#snop_departure_date').datepicker({
            uiLibrary: 'bootstrap4',
            minDate: today,
            maxDate: tomorrow,
            format: format
        });
    },
    init_rooms: function(){

    },
    init_checkout: function(){

    },
    init_thank: function(){

    },
    init: function () {
        this.init_search();
        this.init_rooms();
        this.init_checkout();
        this.init_thank();
    }
}

