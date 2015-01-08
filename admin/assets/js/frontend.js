jQuery(document).ready(function($) {

 /*** 
  * Run this code when the span-toggle link has been tapped
  * or clicked
  */
	$('#q-and-a-repeatables li').on('touchstart click', function (e) {
		e.preventDefault();
		var $span = $(this).find('span'),
			
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';
		
		/* When the li is clicked or touched, we add our animation classes */
		$span.addClass('animate-down');
		/***
		* Determine the direction of the animation and
		* add the correct direction class depending
		* on whether the span was already visible.
		*/
		if ($span.hasClass('span-visible')) {
			$span.addClass('animate-up');
		} else {
			$span.addClass('animate-down');
		}
		/**
		* When the animation (technically a CSS transition)
		* has finished, remove all animating classes and
		* either add or remove the "span-visible" class 
		* depending whether it was visible or not previously.
		*/
		$span.on(transitionEnd, function () {
			$span
				.removeClass('animate-up animate-down')
				.toggleClass('span-visible');
			$span.off(transitionEnd);
		});
   
		
	});
});
