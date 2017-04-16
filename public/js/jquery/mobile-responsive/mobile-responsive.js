$(document).ready(function(){

	var w = $(this).width();
	
	windowWidth(w);

});

$(window).resize(function(e){
	
	var w = $(this).width();
	
	windowWidth(w);

});

function windowWidth(w){

	var body = $("body");

	if(w > 1024){
		if(body.hasClass("state_tablet") || body.hasClass("state_mobile")){
			body.removeClass("state_tablet").removeClass("state_mobile")
		}
	}

	if(w <= 1024 && w >= 600){
		if(body.hasClass("state_mobile")){
			body.addClass("state_mobile").removeClass("state_mobile")
		}else{
			body.addClass("state_tablet")
		}
	}

	if(w <= 559){
		if(body.hasClass("state_tablet")){
			body.addClass("state_mobile").removeClass("state_tablet")
		}else{
			body.addClass("state_mobile")
		}
	}

	console.log(w);
}
