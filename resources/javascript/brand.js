let response;

let pause = true;

$(document).ready(function( ) {
	$("nav.navbar .nav-link").click(function( ) {
		if( $(".navigation").is(":visible") ) {
			$(".navigation").fadeOut(100, function( ) {
				$("body").removeClass("overflow");
			});
		} else {
			$("body").addClass("overflow");
			$(".navigation").fadeIn(100);
		}
	});
	
	$(".submit").submit(function(event) {
		event.preventDefault( );
			
		if(pause) {
			pause = false;
			
			let data = {
				name: $(".submit input[name='name']").val( ),
				email: $(".submit input[name='email']").val( ),
				company: $(".submit input[name='company']").val( ),
				affiliation: $(".submit input[name='affiliation']").val( ),
				message: $(".submit input[name='message']").val( ),
				response: response
			};
			
			$.post("api/contact.php", data, function( ) {
				$(".submit button").text("Your message has been sent. Thank you.");
				
				$(".submit").reset( );
			}).fail(function( ) {
				$(".submit button").text("Please complete the reCaptcha.");
			});
			
			setTimeout(function( ) {
				pause = true;
				
				$(".submit button").text("Send");
			}, 5000);
			
			
			grecaptcha.reset( );
		}
	});
});

function validate(result) {
	response = result;
}