$(function() {
	$(document).on("click", '.calendarButton', function (e){ 
     e.preventDefault(); 
     $.ajax({
        url: $(this).attr('href') + '/' + $('#id_user').val()
        ,success: function(response) {
           $( ".calendar" ).replaceWith( response );
        }
     })
     return false; //for good measure
	});
}); 