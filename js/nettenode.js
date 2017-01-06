(function($) {
	$( "#inv_registerForm" ).submit(function( event ) {

	  		event.preventDefault();
	  		console.log("aa");
	  		if(!$(this).hasClass("disabled")){
				registerFormSubmit($(this));
				$(this).addClass("disabled");
				$(this).find('.submit').attr('disabled','disabled');
			}
	  		
			
	});


function registerFormSubmit(form){
		
		console.log("bb");
		
		
	var inputs = {
		username 			: form.find('input[name="username"]').val(),
		email 		: form.find('input[name="email"]').val(),
		password 		: form.find('input[name="password"]').val(),
		passwordRepeat 	: form.find('input[name="password-repeat"]').val()
 	};
 	
 	
 	$.post(ajax.ajaxurl,{
		action:'invvo_register_ajax',
		inputs: inputs,
	},
	function(response) {
		rsponseObj = $.parseJSON(response);
		console.log(rsponseObj);
		form.find('.message').html(rsponseObj.message);
		if(rsponseObj.state == 0){
			form.removeClass("disabled");
			form.find('.submit').removeAttr('disabled');
		}

	});


}


})( jQuery );