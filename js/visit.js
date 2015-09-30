


$(function() {	
		$( "#inp_fecha" ).datepicker({
			firstDay: 1,
			 autoSize: true,
			 buttonText: "Choose",
			dateFormat: "dd/mm/yy",
			monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
			dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ]
			});
	});



	$(document).ready(function() {		
   $("#inp_time_start").timepicker({
   		hourText: 'Horas',
        minuteText: 'Minutos',
        amPmText: ['AM', 'PM'],
        onHourShow: OnHourShowCallback,
        onMinuteShow: OnMinuteShowCallback                 
   });
                
   $("#inp_time_end").timepicker({
   		hourText: 'Horas',
        minuteText: 'Minutos',
        amPmText: ['AM', 'PM'],
        onHourShow: OnHourShowCallback,
        onMinuteShow: OnMinuteShowCallback
   });
   
});

/* Timepickers callbacks*/
function OnHourShowCallback(hour) {
    if ((hour > 18) || (hour < 9)) {
        return false; 
    }
    return true; 
}
function OnMinuteShowCallback(hour, minute) {
    if ((hour == 18) && (minute >= 00)) { return false; } 
    if ((hour == 9) && (minute < 00)) { return false; }   
    return true;  
}


function timend(){
	var date=new Date();
	
}

function goBack() {
    window.history.back();
}

function gvisit(){
	$("#back-button").show();
}
