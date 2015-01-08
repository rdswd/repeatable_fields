/**
 * Creates a new input element to be appended to the DOM that's used to represent a single
 * Q and A consisting of two fields (Question and Answer) to be referenced in the post.
 *
 * @since    0.4.0
 * @param    object    $    A reference to the jQuery object
 * @return   object         An input element to be appended to the DOM.
 */
function createInputElement( $ ) {
 
    var $inputElement1, $inputElement2, iInputCount;
 
    /* First, count the number of input fields that already exist. This is how we're going to
     * implement the name and ID attributes of the element.
     */
    iInputCount = $( '#q-and-a-repeatables' ).children(':input').length / 2;
 	iInputCount++;
    // Next, create the actual input element and then return it to the caller
	$inputHeader   = 
		$( '<h3>Q&amp;A ' + iInputCount + '</h3>');
    $inputElement1 =
        $( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'question[' + iInputCount + ']' )
            .attr( 'id', 'q-and-a-repeatable-question-' + iInputCount )
            .attr( 'value', '' );
	
	$inputElement2 =
		$( '<input />' )
            .attr( 'type', 'text' )
            .attr( 'name', 'answer[' + iInputCount + ']' )
            .attr( 'id', 'q-and-a-repeatable-answer-' + iInputCount )
            .attr( 'value', '' );
	
	return [$inputHeader, $inputElement1, $inputElement2];
	
}
 
(function( $ ) {
    'use strict';
 
    $(function() {
 
        var $inputElement1, $inputElement2;
 
        $( '#q-and-a-add-repeatable' ).on( 'click', function( evt ) {
 
            evt.preventDefault();
 
            /* Create a new input element that will be used to capture the users input
             * and append it to the container just above this button.
             */
            $( '#q-and-a-repeatables' ).append ( createInputElement( $ ) );
 
 
 
        });
 
    });
 
})( jQuery );