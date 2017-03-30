$(document).ready(function(){

	$(window).load(function() {
		$('body').removeClass('menu-open');
		$("#loader").fadeOut("1000");
	});

	$('#burger').click(function(){
		$('.menu-options').toggleClass('block');
	});
	
});

