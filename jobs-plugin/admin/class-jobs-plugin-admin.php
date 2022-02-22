<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       broiler.com
 * @since      1.0.0
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jobs_Plugin
 * @subpackage Jobs_Plugin/admin
 * @author     M Bilal <muhammadbilalsupple.com>
 */
class Jobs_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jobs_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jobs_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jobs-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jobs_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jobs_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jobs-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}
	// Our custom post type function
function create_cptposttype() {
 
    register_post_type( 'jobs',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'jobs Board' ),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'jobs Board'),
            'show_in_rest' => true,
			'show_in_menu' => true,
			'show_in_admin_bar'=>true,
			'supports'=>array('title'
			)
			
 
        )
    );
}



function add_custom_metabox() {
	
	
		add_meta_box(
			'meta_box_id',                 // Unique ID
			'Custom_Meta_box',      // Box title
			array($this, 'call_back_function'),  // Content callback, must be of type callable
			'jobs'                            // Post type
		);	
}

	// call back function and using for get the custom metabox data data

	function call_back_function( $post ) {
		?>
		<p class="meta-options hcf_field">
        <label for="hcf_location">Location</label><br>
        <input id="hcf_location" type="text" name="hcf_location"  value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_location', true ) ); ?>">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_author">Salary range</label><br>
		<input type="range" min="1" max="100" value="50" class="slider" id="myRange">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_published_time">Timings</label><br>
        <input id="hcf_published_time" type="text" name="hcf_published_time"  value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_published_time', true ) ); ?>">
    	</p>
		<p class="meta-options hcf_field">
        <label for="hcf_benefit"> Benefits</label><br>
        <input id="hcf_benefit" type="text" name="hcf_benefit" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_benefit', true ) ); ?>">
    	</p>
		<?php
	}

	/**
 * Save meta box content.// get the content in the meta box 
 *
 * @param int $post_id Post ID
 */
function save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'hcf_location',
        'hcf_published_time',
        'hcf_benefit',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}


	//add taxonomy  
function create_jobs_taxonomy() {
 
	// Labels part for the GUI
	 
	  $labels = array(
		'name' => _x( 'jobs-category', 'taxonomy general name' ),
		'singular_name' => _x( 'jobs', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search jobs-category' ),
		'popular_items' => __( 'Popular jobs-category' ),
		'all_items' => __( 'All jobs-category' ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __( 'Edit jobs-category' ), 
		'update_item' => __( 'Update Topic' ),
		'add_new_item' => __( 'Add New Topic' ),
		'new_item_name' => __( 'New Topic Name' ),
		'separate_items_with_commas' => __( 'Separate jobs-category with commas' ),
		'add_or_remove_items' => __( 'Add or remove jobs-category' ),
		'choose_from_most_used' => __( 'Choose from the most used jobs-category' ),
		'menu_name' => __( 'jobs-category' ),
	  ); 

// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('jobs-category','jobs',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'jobs' ),
  ));
}
	
// Our custom post type function
function create_2ntsptfile() {
 
    register_post_type( 'application',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Application'),
            ),
            'public' => true,
            'has_archive' => true,
			'menu_icon' => 'dashicons-universal-access',
            'rewrite' => array('slug' => 'Application
			'),
            'show_in_rest' => true,
			'show_in_menu' => true,
			'show_in_admin_bar'=>true,
			'supports'=>array('title'
			)
			
			
        )
    );
}


function add_custom_metabox1() {
	
	
	add_meta_box(
		'meta_box_id',                 // Unique ID
		'Custom_Meta_box',      // Box title
		array($this, 'call_back_function1'),  // Content callback, must be of type callable
		'Application'                            // Post type
	);	
}

// call back function and using for get the custom metabox data data

function call_back_function1($post) {
	?>
	<div class="custom post type">
	<form action="" method="POST">
	
	<p class="">
	<label for="firstname">Full Name</label><br>
	<input type="text" id="firstname" name="firstname"  placeholder="Your last name.."  value="<?php echo get_post_meta( $post->ID, 'firstname', true ); ?>">
	</p> 

	<P>
	<input type="text"  id="lastname" name="lastname" placeholder="Your last name.." value="<?php echo esc_attr( get_post_meta( $post->ID, 'lastname', true ) ); ?>">
	</P>

	<p class="">
	<label for="birth"> Date of Birth</label><br>
	<input type="text" id="birth"  name="birth" placeholder="MM/DD/YYYY"
        onfocus="(this.type='date')"
        onblur="(this.type='text')"value="<?php echo esc_attr( get_post_meta( $post->ID, 'birth', true ) ); ?>">

	</p>
	<p class="">
	<label for="EmailAddress">Email Address</label><br>
	<input type="text" id="EmailAddress" name="EmailAddress" placeholder="Email Address.." value="<?php echo esc_attr( get_post_meta( $post->ID, 'EmailAddress', true ) ); ?>">
	</p>
	

	<p class="">
	<label for="cell">phone Number</label><br>
    <input type="text" type="text" id="cell" name="cell" placeholder="phone Number"  value="<?php echo esc_attr( get_post_meta( $post->ID, 'cell', true ) ); ?>">
    </P>

	<p class="">
	<label for="address">current address</label><br>
    <input type="text" type ="text" id="address" name= "address" placeholder="current address" value="<?php echo esc_attr( get_post_meta( $post->ID, 'address', true ) ); ?>"></textarea>
    </P>
	
	<p class="">
	<input type="file" id="myFile" name="filename">
    <br><br>
    <input type="submit" value="submit" name="submit">
    </P>
	</div>
	<?php



	
	}
}

