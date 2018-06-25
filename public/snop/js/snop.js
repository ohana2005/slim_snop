/**
 * Created by alexradyuk on 6/25/18.
 */


$(function(){
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
});
