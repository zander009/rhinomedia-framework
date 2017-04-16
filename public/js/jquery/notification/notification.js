$(document).ready(function(){
	$(".notification .close").click(function(){
		var item = $(this).attr('data-dismiss');
		
		if(item){
			notifDismiss();
		}
	});

	var dismiss = new Timer(function(){
		var item = $('.notification .close').attr('data-dismiss');
		notifDismiss(item);
	}, 5000);

	$(".notification").mouseover(function(){
		dismiss.pause();
	});

	$(".notification").mouseleave(function(){
		dismiss.play();
	});

});

function notification(state){

	$("body").delegate(".notification", "notifEvent", function(){
		
		var notifier = ".notifier-wrapper";

		$(notifier).addClass(state);

		$(this).addClass('show');

	});

	setTimeout($(".notification").trigger("notifEvent"), 1000);
}

function notifDismiss(){
	setTimeout(function(){
		var notif = $(".notif");
		if(notif.hasClass("show")){
			notif.removeClass("show").addClass("exit")
		}
		setTimeout(function(){
			notif.detach();
		}, 500);
		
	}, 100);
}








