$(document).ready(function(){
	
	$("body").delegate(".popup", "popupEvent", function(){
		$(this).addClass('show');
	});

	$(".popup .close").click(function(){
		var dismiss = $(this).attr('data-dismiss');

		if(dismiss){
			popupDismiss();
		}

	})

	$(".popup .submit").click(function(){
		$("#popup-form").submit();
		
		formSubmit();
	})

	$(".popup .overlay").click(function(){
		var dismiss = $(this).attr('data-dismiss');

		if(dismiss){
			popupDismiss();
		}
	})
})

function popup(){
	new Timer(function(){
		$(".popup").trigger("popupEvent")
	}, 1000)
}

function popupDismiss(){
	setTimeout(function(){

		pophasClass();

		setTimeout(function(){
			var popup = $(".popup");
			popup.detach();
			notification('success');
		}, 600);
		
	}, 100);
}

function formSubmit(){
	var name  = $('#popup-form input[type="text"]').val();
	var email = $('#popup-form input[type="email"]').val();

	if(name != '' && email != ''){
		
		var input = $("#popup-form input");
		
		if(!input.hasClass("error")){
			$.get({
				url: "http://localhost/rhinomedia-f/",
				data: {name: name,email: email},
				dataType: 'html',
				beforeSend: function(){
					$(".popup .submit i").addClass("show");
				}
			}).done(function(data, state){
					
					console.log(state);

					if(state == 'success'){
						popupDismiss();
					}else{

					}
				})
		}
	}

	console.log(name + '\n' + email);
}

function pophasClass(){
	var popup = $(".popup");
			
	if(popup.hasClass("show")){
		popup.addClass("exit").removeClass("show");
	}
}