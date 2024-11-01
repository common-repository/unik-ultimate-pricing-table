<?php
namespace JLTUNIK\Inc\Classes;


// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Unik_CPT
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Unik_CPT {

	/**
	 * Construct Method
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
    public function __construct(){
        add_action('init', [ $this, 'jltunik_register_pricing_table_post_type' ]);
        add_filter( 'enter_title_here', [ $this, 'jltunik_pricing_title' ] );
        add_filter( 'cmb_meta_boxes', [ $this, 'jltunik_pricing_features_meta_box' ] );
        add_filter( 'manage_edit-jwt_unik_pricing_columns', [ $this, 'jltunik_pricing_edit_pricing_table_columns' ] );
        add_action( 'manage_jwt_unik_pricing_posts_custom_column', [ $this, 'jltunik_pricing_table_manage_pricing_tables_columns'], 10, 2  );

		add_action( 'load-post.php', [ $this, 'jltunik_pricing_layout_meta_boxes_setup' ] );
		add_action( 'load-post-new.php', [ $this, 'jltunik_pricing_layout_meta_boxes_setup' ] );

    }


	function jltunik_pricing_layout_meta_boxes_setup() {

	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', [ $this, 'jltunik_pricing_layout_add_meta_boxes' ] );

	  /* Save post meta on the 'save_post' hook. */
	 // add_action( 'save_post', 'jwt_unik_pricing_layout_save_meta', 10, 2 );
	}

	// Manage Pricing Table Columns
	function jltunik_pricing_edit_pricing_table_columns( $columns ) {
	  $columns = array(
	    'cb' => '<input type="checkbox" />',
	    'title' => __( 'Pricing Table Name', 'unik-ultimate-pricing-table' ),
	    'jwt_unik_pricing_shortcode' => __( 'Pricing Shortcode', 'unik-ultimate-pricing-table' ),
	    'jwt_unik_pricing_shortcode' => __( 'Pricing Shortcode', 'unik-ultimate-pricing-table' ),
	    );

	  return $columns;
	}



	function jltunik_pricing_layout_add_meta_boxes() {

	  add_meta_box(
	    'jwt_pricing-design-class',      // Unique ID
	    esc_html__( 'Design Layout', 'unik-ultimate-pricing-table' ),    // Title
	    [ $this, 'jwt_unik_pricing_layout_meta_box' ],   // Callback function
	    'jwt_unik_pricing',         // Admin page (or post type)
	    'side',         // Context
	    'high'         // Priority
	  );
	}



	/* Display the post meta box. */
	function jwt_unik_pricing_layout_meta_box( $object, $box ) {
		wp_nonce_field( basename( __FILE__ ), 'jwt_unik_pricing_nonce' ); ?>

	  <div class="design-preview">
	        <img src="<?php echo JLTUNIK_IMAGES .'/layout-2.png';?>" />    
	  </div> 
	<?php }



	// Manage Pricing Table
	function jltunik_pricing_table_manage_pricing_tables_columns( $column ){
	  global $post;
	  $post->ID;

	  if( $post->post_type != 'jwt_unik_pricing' ) return;

	  //if( $column == 'jwt_unik_package_price' ) echo get_post_meta( $post->ID, 'jwt_unik_package_price', true );

	  switch ($column) {
	    case 'title':
	    echo get_the_title();
	    break;

	    case 'jwt_unik_pricing_shortcode':
	    echo '[unik_pricing id="' . get_the_ID() . '"]';
	    break;

	    default:
	                      # code...
	    break;
	  }
	}


	// Change Enter Title Here
    function jltunik_pricing_title( $title ){
		$screen = get_current_screen();
			if  ( 'jwt_unik_pricing' == $screen->post_type ) {
		    	$title = 'Pricing Title';
		  	}  
		return $title;    	
    }


	function jltunik_register_pricing_table_post_type(){

		$labels = array(
	   'name' => _x( "Unik Pricing", 'unik-ultimate-pricing-table' ),
	   'singular_name' => _x( "Unik Pricing", 'unik-ultimate-pricing-table' ),
	   'add_new_item' => _x( "Add New Pricing Table", 'unik-ultimate-pricing-table' ),
	   'edit_item' => _x( "Edit Package", 'unik-ultimate-pricing-table' ),
	   'new_item' => _x( "New Package", 'unik-ultimate-pricing-table' ),
	   'view_item' => _x( "View Pricing Package", 'unik-ultimate-pricing-table' ),
	   'search_items' => _x( "Search Pricing Package", 'unik-ultimate-pricing-table' ),
	   'not_found' => _x( "No Pricing Package Found", 'unik-ultimate-pricing-table' ),
	   'not_found_in_trash' => _x( "No Pricing Package Found in Trash", 'unik-ultimate-pricing-table' ),
	   'parent_item_colon' => _x( "Parent Pricing Package", 'unik-ultimate-pricing-table' ),
	   'menu_name' => _x( "Unik Pricing", 'unik-ultimate-pricing-table' )
	   );

		$args = array(
			'labels' => $labels,
			'heirarchical' => false,
			'descriptin' => 'Pricing Package',
			'supports'  => array('title'),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menu' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post'
	   );

		register_post_type( 'jwt_unik_pricing', $args );
	}



	function jltunik_pricing_features_meta_box( $meta_boxes ) {
	  $meta_boxes[] = array(

	    'id'          => 'jwt_unik_pt_feature',
	    'title'       => 'Pricing Column Features',
	    'pages'       => array('jwt_unik_pricing'),
	    'context'     => 'normal',
	    'priority'    => 'high',
	    'show_names'  => true, // Show field names on the left
	    'fields' => array(

	      array( 
	        'id'   => 'jwt_unik_columns', 
	        'name'    => 'Pricing Table Details', 
	        'type' => 'group',
	        'repeatable'     => true,
	        'repeatable_max' => 16,
	        
	        'fields' => array(

	          array(
	            'id'              => 'pricing_table_title',
	            'name'            => 'Pricing Table Name',                
	            'type'            => 'text',
	            'cols'            => 5
	            ),          

	          array(
	            'id'              => 'pricing_sub_title',
	            'name'            => 'Sub Title',                
	            'type'            => 'text',
	            'cols'            => 4
	            ),

	          array( 
	            'id'      => 'pricing_bg_color', 
	            'name'    => 'Color', 
	            'type'    => 'colorpicker', 
	            'cols'    =>  3,
	            'default' => '#69d2e7'
	            ),

	          array(
	            'id'              => 'features',
	            'name'            => 'Features',                
	            'type'            => 'text',
	            'repeatable'      => true,
	            'repeatable_max'  => 12,
	            'cols'            => 4
	            ),

	          array(
	            'id'              => 'package_currency',
	            'name'            => 'Package Currency', 
	            'type'            => 'text',
	            'cols'            => 2,
	            'default'         => '$'
	            ),

	          array(
	            'id'              => 'package_price',
	            'name'            => 'Price ( USD $ )', 
	            'type'            => 'text',
	            'cols'            => 2,
	            'default'         => '10'
	            ),

	          // array(
	          //   'id'              => 'sub_price',
	          //   'name'            => 'Sub Price', 
	          //   'type'            => 'text',
	          //   'cols'            => 2,
	          //   'default'         => '.00'
	          //   ),

	          array(
	            'id'              => 'pricing_per',
	            'name'            => 'Month / Year',                
	            'type'            => 'text',
	            'cols'            => 2,
	            'default'         => 'month'
	            ),

	          array(
	            'id'              => 'package_buy_link',
	            'name'            => 'Buy Now Link',                
	            'type'            => 'text_url',
	            'default'         => '#',
	            'cols'            => 6                
	            ),

	          array(
	            'id'              => 'button',
	            'name'            => 'Button Text',                
	            'type'            => 'text',
	            'cols'            => 6,
	            'default'         => 'Sign Up'
	            )

	          )
	      )
	  )
	);


	return $meta_boxes;
	}




}