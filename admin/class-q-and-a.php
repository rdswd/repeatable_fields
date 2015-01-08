<?php
 
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    RDS_Q_and_A
 * @subpackage RDS_Q_and_A/admin
 */
 
/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @author     Ryan Santschi
 */
class Q_and_A_Admin {
 
    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;
 
    /**
     * The version of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
 
	/**
	 * A reference to the meta box.
	 *
	 * @since    0.2.0
	 * @access   private
	 * @var      Q_and_A_Meta_Box    $meta_box    A reference to the meta box for the plugin.
	 */
	private $meta_box;
	
    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.0
     * @var      string    $name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct( $name, $version ) {
 
        $this->name = $name;
        $this->version = $version;
		
		$this->meta_box = new Q_and_A_Meta_Box();
    }
	
	/**
	 * Registers the hooks and their associated callback functions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function initialize_hooks() {
		
		$this->meta_box->initialize_hooks();
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );	
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_js') );
	}
	
	/**
	 * Enqueues all files specifically for the dashboard.
	 *
	 * @since    0.2.0
	 */
	public function enqueue_admin_styles() {

		wp_enqueue_style(
			$this->name . '-admin',
			plugin_dir_url( __FILE__ ) . 'assets/css/admin.css',
			false,
			$this->version
		);

	}
	

	/**
	 * Includes the JavaScript necessary to control the toggling of the tabs in the
	 * meta box that's repretented by this class.
	 *
	 * @since    0.2.0
	 */
	public function enqueue_admin_scripts() {
		
		/**
		 * Includes our array of post types
		 */
		include( 'q-and-a-post-types.php' );
		
		if ( in_array( get_current_screen()->post_type, $q_and_a_post_types ) ){

			wp_enqueue_script(
				$this->name . '-repeatable',
				plugin_dir_url( __FILE__ ) . 'assets/js/q-and-a-repeatable.js',
				array( 'jquery' ),
				$this->version
			);

		}
	}
	
	/**
	 * Include some styling for the question and answers on the the frontend
	 *
	 * @since 0.4.0
	 */
	public function enqueue_frontend_styles(){
		
		wp_enqueue_style(
			$this->name	. '-frontend-styles',
			plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css',
			false,
			$this->version
		);
	}
	
	/**
	 * Includes the JavaScript necessary to hide/show front end answers
	 *
	 * @since    0.4.0
	 */
	public function enqueue_frontend_js() {

		wp_enqueue_script(
			$this->name . '-frontend-js',
			plugin_dir_url( __FILE__ ) . 'assets/js/frontend.js',
			array( 'jquery' ),
			$this->version
		);

	}
	
}