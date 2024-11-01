<?php
namespace JLTUNIK\Inc\Classes;


// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcodes
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Shortcodes {

	/**
	 * Construct Method
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
    public function __construct(){
    	add_shortcode( 'unik_pricing', [ $this, 'jltunik_pricing_table_shortcode' ] );
	}


		
	/* 
	* Unik Pricing Table Shortcode
	*/

	function jltunik_pricing_table_shortcode( $atts , $content = null ) {
		global $post;
		extract( shortcode_atts(
			array(
				'id' => '',
				), $atts )
		);

		// WP_Query arguments
		$args = array (
			'post_type'  => 'jwt_unik_pricing',
			'p'          => $id,
			);

		// The Query
		$block1Featured= new \WP_Query( $args );

		echo '<div class="pricing-tables clearfix"><div class="container"><div class="row"><div class="planning-area"><div class="format-2">';

		$do_not_duplicate = array(); 
		while ($block1Featured->have_posts()) { $block1Featured->the_post();
		$do_not_duplicate[] = $post->ID;

		$featuress = get_post_meta( get_the_ID(), 'jwt_unik_columns');
			foreach ($featuress as $feature) {	?>
	            <div class="col-sm-4 col-xs-6">
	              <div class="item item-3">
	                <div class="plan-top">
	                  <h3 class="plan-name">
	                  	<?php echo $feature['pricing_table_title']; ?>
	                  </h3>
	                  <p class="plan-description">
	                  	<?php echo $feature['pricing_sub_title']; ?>
	                  </p>
	                  <div class="plan-cost">
	                    <span class="currency">
	                    	<?php echo $feature['package_currency']; ?>                    
	                    </span>
	                    <span class="cost">
	                    	<?php echo $feature['package_price']; ?>
	                    	<!-- <span><?php // if( $feature['sub_price'] ) echo $feature['sub_price']; ?></span> -->
	                    </span>
	                    <span class="duration"><?php echo $feature['pricing_per']; ?></span>
	                  </div><!-- /.plan-cost -->
	                </div><!-- /.plan-top -->
	                <div class="plan-details">
	                  	<ul>
		            		<?php foreach ($feature['features'] as $value) { ?>
			                    <li>
			                    	<p>
			                    		<?php echo $value; ?>
			                    	</p>
			                    </li>	
		                  	<?php } ?>					                  			
	                  	</ul>
	                </div><!-- /.plan-details -->
	                <div class="plan-bottom">
	                  <a class="btn pricing-btn" href="#">Select Plan</a>
	                </div><!-- /.plan-bottom -->
	              </div><!-- /.item -->
	            </div>

	<?php } 

	} wp_reset_postdata();

		if ( $block1Featured->have_posts() ) {
			echo get_post_meta( $post->ID, '_jwt_unik_pricing_layout', true);
			while ( $block1Featured->have_posts() ) { $block1Featured->the_post(); 

        $JWT_Pricing_Columns = get_post_meta( get_the_ID(), 'jwt_unik_columns');				
			foreach ($JWT_Pricing_Columns as $query) {
				$JWT_Pricing_Columns = $query;
					echo jltunik_exclude_design_presets();
				} 
					}
						wp_reset_postdata();
					} else{  ?>
						<p><?php _e( 'Something Wrong on your Pricing Table, Please Check the ID.' ); ?></p>
		<?php }	?>		
									
							</div><!-- /. format-2 -->
						</div><!-- /.planning-area -->					
					</div><!-- /.row -->
				</div><!-- /.container -->
			</div><!-- /#pricing-tables -->
			
			
		<?php
	}
		

}