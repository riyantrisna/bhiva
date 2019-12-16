$(document).ready(function() {
	$(".dates_register").datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
    });
    
    $(".dates_birthday").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ( (charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
    return true;
}

