jQuery(document).ready(function($) {

 /*** 
  * Run this code when the menu-toggle link has been tapped
  * or clicked
  */
	$('#q-and-a-repeatables li').on('touchstart click', function (e) {
		e.preventDefault();
		var $span = $(this).find('span');
		$span.toggle('slow');
		console.log($span);
		
	});
});
