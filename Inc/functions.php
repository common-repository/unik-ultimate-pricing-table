<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_Unik_Pricing_Table
 * @license       Copyright JLT_Unik_Pricing_Table
 */

if ( ! function_exists( 'jltunik_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltunik_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltunik_option( $section = 'jltunik_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jltunik_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltunik_exclude_pages() {
		return jltunik_option( 'jltunik_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jltunik_exclude_pages_except' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltunik_exclude_pages_except() {
		return jltunik_option( 'jltunik_triggers', 'exclude_pages_except', array() );
	}
}





if ( ! function_exists( 'jltunik_exclude_design_presets' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltunik_exclude_design_presets() {

		$jwt_pricing_table_design = get_post_meta( get_the_ID(), '_jwt_unik_pricing_layout', true );

		if($jwt_pricing_table_design == "1" ){ ?>
			
			<div class="col-sm-3 col-xs-6">
				<div class="item <?php echo $query['pricing_bg_color']; ?>">
					<div class="plan-top">
						<h3 class="plan-name">
							<?php echo $query['pricing_table_title']; ?>
						</h3>
						<div class="plan-cost">
							<span class="currency"><?php echo $query['package_currency']; ?></span>
							<span class="cost"><?php echo $query['package_price']; ?></span>
							<?php if($query['sub_price']){ ?>
								<span class="cent"><?php echo $query['sub_price']; ?></span>
							<?php } ?>													
							<span class="duration"><?php echo $query['pricing_per']; ?></span>
						</div><!-- /.plan-cost -->
					</div><!-- /.plan-top -->
					<div class="plan-details">
						<ul>													
							<?php 
							$features = $query['features'];
							foreach ($features as $feature) { ?>															
							<li>
								<p>
									<?php echo $feature; ?>
								</p>
							</li>
							<?php } ?>													
						</ul>
					</div><!-- /.plan-details -->
					<div class="plan-bottom">
						<a class="btn pricing-btn" href="<?php echo $query['package_buy_link']; ?>"><?php echo $query['button']; ?></a>
					</div><!-- /.plan-bottom -->
				</div><!-- /.item -->
			</div>
	<?php } else if( $jwt_pricing_table_design ==  "2" ){ ?>
	          <div class="col-sm-4 col-xs-6">
	              <div class="item <?php echo $query['pricing_bg_color']; ?>">
	                <div class="plan-top">
	                  <h3 class="plan-name">
	                  	<?php echo $query['pricing_table_title']; ?>
	                  </h3>
	                  <p class="plan-description">
	                  	<?php echo $query['pricing_sub_title']; ?>
	                  </p>
	                  <div class="plan-cost">
	                    <span class="currency"><?php echo $query['package_currency']; ?></span>
	                    <span class="cost"><?php echo $query['package_price']; ?></span>

	                    <?php if($query['sub_price']){ ?>
	                    	<span class="cent"><?php echo $query['sub_price']; ?></span>
	                    <?php } ?>	

	                    <span class="duration"><?php echo $query['pricing_per']; ?></span>
	                  </div><!-- /.plan-cost -->
	                </div><!-- /.plan-top -->
	                <div class="plan-details">
	                  <ul>

	                  	<?php 
	                  	$features = $query['features'];
	                  	foreach ($features as $feature) { ?>															
	                  	<li>
	                  		<p>
	                  			<?php echo $feature; ?>
	                  		</p>
	                  	</li>
	                  	<?php } ?>		

	                  </ul>
	                </div><!-- /.plan-details -->
	                <div class="plan-bottom">
	                  <a class="btn pricing-btn" href="<?php echo $query['package_buy_link']; ?>"><?php echo $query['button']; ?></a>
	                </div><!-- /.plan-bottom -->
	              </div><!-- /.item -->
	            </div>
	<?php } else if( $jwt_pricing_table_design ==  "3" ){ ?>

	            <div class="col-sm-3 col-xs-6">
	              <div class="item <?php echo $query['pricing_bg_color']; ?> <?php if( get_post_meta( get_the_ID(), '_jwt_unik_pricing_layout', true ) ==  "4" ) { echo 'text-center'; } ; ?>">
	                <div class="plan-top">
	                  <h3 class="plan-name">
	                  	<?php echo $query['pricing_table_title']; ?>
	                  </h3>
	                  <div class="plan-cost">
	                    <span class="currency"><?php echo $query['package_currency']; ?></span>
	                    <span class="cost"><?php echo $query['package_price']; ?></span>
	                    <span class="duration"><?php echo $query['pricing_per']; ?></span>
	                  </div><!-- /.plan-cost -->
	                </div><!-- /.plan-top -->
	                <div class="plan-details">
	                  <ul>                    
	                    <?php 
	                    $features_avail = $query['features_avail'];
	                    foreach ($features_avail as $ft) { 
	                    	?>															
		                    <li class="<?php echo ($ft == "yes")? "has-ability" : "has-not-ability"; ?>">
		                    	<span class="ability-icon"><i class="<?php echo ($ft == "yes")? "icon-check" : "icon-close"; ?> icons"></i></span>
		                    </li>                 
	                    <?php } ?>	
	                  </ul>
	                </div><!-- /.plan-details -->
	                <div class="plan-bottom">
	                  <a class="btn pricing-btn" href="<?php echo $query['package_buy_link']; ?>"><?php echo $query['button']; ?></a>
	                </div><!-- /.plan-bottom -->
	              </div><!-- /.item -->
	            </div>
	<?php }
		

	}
}