$(document).ready(function(){
	$( ".form-container" ).delegate( "*", "focus blur", function() {
	  
	  var elem = $( this );
	  var id = elem.attr('data-id');
	  var item = $("."+id);

	  item.toggleClass( "focused", elem.is( ":focus" ) );

	});

	$("#login-form").validate({
		rules: {
			username: "required",
			password: {
				required: true,
				minlength: 1
			},
		},
		messages: {
			first_name: "Please enter your username.",
			last_name: {
				required: "Please enter your password.",
				minlength: "Password must be atleast 1 characters length."
			},
		}
	});

	$("#popup-form").validate({
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			},
		}
	});

});