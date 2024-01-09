

// Tooltips for Social Links
$('.tooltip-social').tooltip({
  selector: "a[data-toggle=tooltip]"
})



$(document).ready(function($) {
	$('.navbar-nav a').on('click', function(e) {
		e.preventDefault();
		offset = $($(this).attr('href')).offset().top - 80;
		//alert(offset);
		$('body,html').animate({scrollTop:offset}, 1000);
	});
	
	// Подсвечивание ссылок граф. меню при сколлинге страницы
	$(window).scroll(function() {
		var offsetCorrect = $(window).scrollTop();
		var targetPosition = 120;
		$('.anchor').each(function() {		
			if( ( $(this).offset().top - offsetCorrect ) <= targetPosition) {
				$(".navbar-nav a")
				.removeClass('active')
				.filter("[href$='#"+$(this).attr('id')+"']")
				.addClass('active');
			}
		});
	});
});



