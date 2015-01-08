<?php
/**
 * Renders the content of the meta box in the admin.
 *
 * @since    0.2.0
 * @package    RDS_Q_and_A
 * @subpackage RDS_Q_and_A/admin/views
 */
 
/**
 * Include template
 */
	include_once( 'partials/repeatable.php' );
	
	// Add a nonce field for security
	wp_nonce_field( 'q_and_a_save', 'q_and_a_nonce' );
 
?>