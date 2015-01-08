<?php

/**
 * Represents Q and A Meta Box.
 *
 * @since	1.0.0
 *
 * Registers the meta box with the WordPress API, sets its properties, and renders the content
 * by including the markup from its associated view.
 *
 * @package    RDS_Q_and_A
 * @subpackage RDS_Q_and_A/admin
 * @author     Ryan Santschi
 */

/** 
 * Q and A Meta Box Class.
 *
 * Registers the meta box with the WordPress API, sets its properties, and renders the content
 * by including the markup from its associated view.
 *
 * @package    RDS_Q_and_A
 * @subpackage RDS_Q_and_A/admin
 * @author		Ryan Santschi
 */

class Q_and_A_Meta_Box{

    /**
     * Register this class with the WordPress API
     *
     * @since	1.0.0
     */
    public function initialize_hooks() {
		
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		
	}
	
	/**
	 * The function responsible for creating the actual meta box.
	 *
	 * @since	1.0.0
	 */
	public function add_meta_box(){
		
		/**
		 * Includes our array of post types
		 */
		include( 'q-and-a-post-types.php' );
		
		foreach ( $q_and_a_post_types as $post_type ) {
			add_meta_box(
				'q-and-a',
				'Questions and Answers',
				array( $this, 'display_meta_box' ),
				$post_type, 
				'normal',
				'default'
			);
		}
	}
	
	
    /**
     * Renders the content of the meta box.
     *
     * @since    1.0.0
     */
    public function display_meta_box() {
		
		include_once( 'views/q-and-a-admin.php' );
    }
	
	/**
	 * Sanitizes and serializes the information associated with this post.
	 *
	 * @since    0.5.0
	 *
	 * @param    int    $post_id    The ID of the post that's currently being edited.
	 */
	public function save_post( $post_id ) {

		/* If we're not working with a 'post' post type or the user doesn't have permission to save,
		 * then we exit the function.
		 */
		if ( ! $this->user_can_save( $post_id, 'q_and_a_nonce', 'q_and_a_save' ) ) {
			return;
		}

		/* 
		 * If there is no question there is no reason to save
		 */
		if ( ! $this->value_exists( 'question' ) ) {
			return;	
		}
		/*
		 * We get the old values and begin to get the new ones if they aren't empty
		 * We count the amount of questions for a for loop
		 */
			$old = get_post_meta($post_id, 'q-and-a-repeatables', true);
			$new = array();
			
			$question =	( !empty( $_POST['question'] ) ) ? $_POST['question'] : "";
			$answer =	( !empty( $_POST['answer'] ) ) ? $_POST['answer'] : "";
			
			$count = count( $question );
		/*
		 * We loop through as long as $i is less than or equal to $count.
		 * I don't understand this. I think it should only be less than. If count was 1
		 * than it would loop twice. One loop with i being zero is less than count 1  and one 
		 * loop as i being one is equal to count as one
		 */
			for ( $i = 0; $i <= $count; $i++ ) {
				if ( ! empty($question[$i]) ) :
					$new[$i]['question'] = stripslashes( strip_tags( $question[$i] ) );
				
					if ( ! empty($answer[$i]) )
						$new[$i]['answer'] = stripslashes( strip_tags( $answer[$i] ) );
				endif;
			}
		if ( !empty( $new ) && $new != $old )
			$this->update_post_meta( 
				$post_id, 
				'q-and-a-repeatables', 
				$new
			);
		elseif ( empty($new) && $old )
			$this->delete_post_meta( 
				$post_id, 
				'q-and-a-repeatables', 
				$old 
			);
		
	}

	/**
	 * Determines whether or not a value exists in the $_POST collection
	 * identified by the specified key.
	 *
	 * @since   1.0.0
	 *
	 * @param   string    $key    The key of the value in the $_POST collection.
	 * @return  bool              True if the value exists; otherwise, false.
	 */
	private function value_exists( $key ) {
		return ! empty( $_POST[ $key ] );
	}
	
	/**
	 * Deletes the specified meta data associated with the specified post ID
	 * based on the incoming key.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    int  	$post_id    The ID of the post containing the meta data
	 * @param    string   $meta_key   The ID of the meta data value
	 */
	private function delete_post_meta( $post_id, $meta_key ) {
		
		if ( '' !== get_post_meta( $post_id, $meta_key, true ) ) {
			delete_post_meta( $post_id, $meta_key );
		}
		
	}

	/**
	 * Updates the specified meta data associated with the specified post ID
	 * based on the incoming key.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    int      $post_id    The ID of the post containing the meta data
	 * @param    string   $meta_key   The ID of the meta data value
	 * @param    mixed    $meta_value The sanitized meta data
	 */
	private function update_post_meta( $post_id, $meta_key, $meta_value ) {
		
		if ( is_array( $_POST[ $meta_key ] ) ) {
			$meta_value = array_filter( $_POST[ $meta_key ] );
		}
		
		update_post_meta( $post_id, $meta_key, $meta_value );
	}
	
	/**
	 * Sanitizes the data in the $_POST collection identified by the specified key
	 * based on whether or not the data is text or is an array.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    string        $key                      The key used to retrieve the data from the $_POST collection.
	 * @param    bool          $is_array    Optional.    True if the incoming data is an array.
	 * @return   array|string                            The sanitized data.
	 */
	private function sanitize_data( $key, $is_array = false ) {
		
		$sanitized_data = null;
		
		if ( $is_array ) {
		
			$resources = $_POST[ $key ];
			$sanitized_data = array();
			
			foreach ( $resources as $resource ) {
				
				$resource = esc_url( strip_tags( $resource ) );
				if ( ! empty( $resource ) ) {
					$sanitized_data[] = $resource;
				}
			}
		} else {
		
			$sanitized_data = '';
			$sanitized_data = trim( $_POST[ $key ] );
			$sanitized_data = esc_textarea( strip_tags( $sanitized_data ) );
		
		}
		
		return $sanitized_data;

	}
	
	/**
	 * Verifies that the post type that's being saved is actually a post (versus a page or another
	 * custom post type.
	 *
	 * @since       0.5.0
	 * @access      private
	 * @return      bool      Return if the current post type is a post; false, otherwise.
	 */
	private function is_valid_post_type() {
		
		/**
		 * Includes our array of post types
		 */
		include_once( 'q-and-a-post-types.php' );
		
		return ! empty( $_POST['post_type'] ) && ( in_array( get_current_screen()->post_type, $q_and_a_post_types ) );
	}
	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * @since       0.5.0
	 * @access      private
	 * @param		int		$post_id	  The ID of the post being save
	 * @param       string  $nonce_action The name of the action associated with the nonce.
	 * @param       string  $nonce_id     The ID of the nonce field.
	 * @return		bool				  Whether or not the user has the ability to save this post.
	 */
	private function user_can_save( $post_id, $nonce_action, $nonce_id ) {
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ $nonce_action ] ) && wp_verify_nonce( $_POST[ $nonce_action ], $nonce_id ) );
	    // Return true if the user is able to save; otherwise, false.
	    return ! ( $is_autosave || $is_revision ) && $this->is_valid_post_type() && $is_valid_nonce;
	}
	
}