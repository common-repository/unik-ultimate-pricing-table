<?php
namespace JLTUNIK\Inc\Classes;

use JLTUNIK\Inc\Classes\Notifications\Base\User_Data;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feedback
 *
 * @author Jewel Theme <support@jeweltheme.com>
 */
class Feedback {

    use User_Data;

	/**
	 * Construct Method
	 *
	 * @return void
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
    public function __construct(){
        add_action( 'admin_enqueue_scripts' , [ $this,'admin_suvery_scripts'] );
        add_action( 'admin_footer' , [ $this , 'deactivation_footer' ] );
        add_action( 'wp_ajax_jltunik_deactivation_survey', array( $this, 'jltunik_deactivation_survey' ) );

    }


    public function proceed(){

        global $current_screen;
        if(
            isset($current_screen->parent_file)
            && $current_screen->parent_file == 'plugins.php'
            && isset($current_screen->id)
            && $current_screen->id == 'plugins'
        ){
           return true;
        }
        return false;

    }

    public function admin_suvery_scripts($handle){
        if('plugins.php' === $handle){
            wp_enqueue_style( 'jltunik-survey' , JLTUNIK_ASSETS . 'css/plugin-survey.css' );
        }
    }

    /**
     * Deactivation Survey
     */
    public function jltunik_deactivation_survey(){
        check_ajax_referer( 'jltunik_deactivation_nonce' );

        $deactivation_reason  = ! empty( $_POST['deactivation_reason'] ) ? sanitize_text_field( wp_unslash( $_POST['deactivation_reason'] ) ) : '';

        if( empty( $deactivation_reason )){
            return;
        }

        $email = get_bloginfo( 'admin_email' );
        $author_obj = get_user_by( 'email', $email );
        $user_id    = $author_obj->ID;
        $full_name  = $author_obj->display_name;

        $response = $this->get_collect_data( $user_id, array(
            'first_name'              => $full_name,
            'email'                   => $email,
            'deactivation_reason'     => $deactivation_reason,
        ) );

        return $response;
    }


    public function get_survey_questions(){

        return [
			'no_longer_needed' => [
				'title' => esc_html__( 'I no longer need the plugin', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => '',
			],
			'found_a_better_plugin' => [
				'title' => esc_html__( 'I found a better plugin', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => esc_html__( 'Please share which plugin', 'unik-ultimate-pricing-table' ),
			],
			'couldnt_get_the_plugin_to_work' => [
				'title' => esc_html__( 'I couldn\'t get the plugin to work', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => '',
			],
			'temporary_deactivation' => [
				'title' => esc_html__( 'It\'s a temporary deactivation', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => '',
			],
			'jltunik_pro' => [
				'title' => sprintf( esc_html__( 'I have %1$s Pro', 'unik-ultimate-pricing-table' ), JLTUNIK ),
				'input_placeholder' => '',
				'alert' => sprintf( esc_html__( 'Wait! Don\'t deactivate %1$s. You have to activate both %1$s and %1$s Pro in order for the plugin to work.', 'unik-ultimate-pricing-table' ), JLTUNIK ),
			],
			'need_better_design' => [
				'title' => esc_html__( 'I need better design and presets', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => esc_html__( 'Let us know your thoughts', 'unik-ultimate-pricing-table' ),
			],
            'other' => [
				'title' => esc_html__( 'Other', 'unik-ultimate-pricing-table' ),
				'input_placeholder' => esc_html__( 'Please share the reason', 'unik-ultimate-pricing-table' ),
			],
		];
    }


        /**
         * Deactivation Footer
         */
        public function deactivation_footer(){

        if(!$this->proceed()){
            return;
        }

        ?>
        <div class="jltunik-deactivate-survey-overlay" id="jltunik-deactivate-survey-overlay"></div>
        <div class="jltunik-deactivate-survey-modal" id="jltunik-deactivate-survey-modal">
            <header>
                <div class="jltunik-deactivate-survey-header">
                    <h3><?php echo wp_sprintf( '%1$s %2$s', JLTUNIK, __( '- Feedback', 'unik-ultimate-pricing-table' ),  ); ?></h3>
                </div>
            </header>
            <div class="jltunik-deactivate-info">
                <?php echo wp_sprintf( '%1$s %2$s', __( 'If you have a moment, please share why you are deactivating', 'unik-ultimate-pricing-table' ), JLTUNIK ); ?>
            </div>
            <div class="jltunik-deactivate-content-wrapper">
                <form action="#" class="jltunik-deactivate-form-wrapper">
                    <?php foreach($this->get_survey_questions() as $reason_key => $reason){ ?>
                        <div class="jltunik-deactivate-input-wrapper">
                            <input id="jltunik-deactivate-feedback-<?php echo esc_attr($reason_key); ?>" class="jltunik-deactivate-feedback-dialog-input" type="radio" name="reason_key" value="<?php echo $reason_key; ?>">
                            <label for="jltunik-deactivate-feedback-<?php echo esc_attr($reason_key); ?>" class="jltunik-deactivate-feedback-dialog-label"><?php echo esc_html( $reason['title'] ); ?></label>
							<?php if ( ! empty( $reason['input_placeholder'] ) ) : ?>
								<input class="jltunik-deactivate-feedback-text" type="text" name="reason_<?php echo esc_attr( $reason_key ); ?>" placeholder="<?php echo esc_attr( $reason['input_placeholder'] ); ?>" />
							<?php endif; ?>
                        </div>
                    <?php } ?>
                    <div class="jltunik-deactivate-footer">
                        <button id="jltunik-dialog-lightbox-submit" class="jltunik-dialog-lightbox-submit"><?php echo esc_html__( 'Submit &amp; Deactivate', 'unik-ultimate-pricing-table' ); ?></button>
                        <button id="jltunik-dialog-lightbox-skip" class="jltunik-dialog-lightbox-skip"><?php echo esc_html__( 'Skip & Deactivate', 'unik-ultimate-pricing-table' ); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            var deactivate_url = '#';

            jQuery(document).on('click', '#deactivate-unik-ultimate-pricing-table', function(e) {
                e.preventDefault();
                deactivate_url = e.target.href;
                jQuery('#jltunik-deactivate-survey-overlay').addClass('jltunik-deactivate-survey-is-visible');
                jQuery('#jltunik-deactivate-survey-modal').addClass('jltunik-deactivate-survey-is-visible');
            });

            jQuery('#jltunik-dialog-lightbox-skip').on('click', function (e) {
                e.preventDefault();
                window.location.replace(deactivate_url);
            });


            jQuery(document).on('click', '#jltunik-dialog-lightbox-submit', async function(e) {
                e.preventDefault();

                jQuery('#jltunik-dialog-lightbox-submit').addClass('jltunik-loading');

                var $dialogModal = jQuery('.jltunik-deactivate-input-wrapper'),
                    radioSelector = '.jltunik-deactivate-feedback-dialog-input';
                $dialogModal.find(radioSelector).on('change', function () {
                    $dialogModal.attr('data-feedback-selected', jQuery(this).val());
                });
                $dialogModal.find(radioSelector + ':checked').trigger('change');


                // Reasons for deactivation
                var deactivation_reason = '';
                var reasonData = jQuery('.jltunik-deactivate-form-wrapper').serializeArray();

                jQuery.each(reasonData, function (reason_index, reason_value) {
                    if ('reason_key' == reason_value.name && reason_value.value != '') {
                        const reason_input_id = '#jltunik-deactivate-feedback-' + reason_value.value,
                            reason_title = jQuery(reason_input_id).siblings('label').text(),
                            reason_placeholder_input = jQuery(reason_input_id).siblings('input').val(),
                            format_title_with_key = reason_value.value + ' - '  + reason_placeholder_input,
                            format_title = reason_title + ' - '  + reason_placeholder_input;

                        deactivation_reason = reason_value.value;

                        if ('found_a_better_plugin' == reason_value.value ) {
                            deactivation_reason = format_title_with_key;
                        }

                        if ('need_better_design' == reason_value.value ) {
                            deactivation_reason = format_title_with_key;
                        }

                        if ('other' == reason_value.value) {
                            deactivation_reason = format_title_with_key;
                        }
                    }
                });

                await jQuery.ajax({
                        url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
                        method: 'POST',
                        // crossDomain: true,
                        async: true,
                        // dataType: 'jsonp',
                        data: {
                            action: 'jltunik_deactivation_survey',
                            _wpnonce: '<?php echo esc_js( wp_create_nonce( 'jltunik_deactivation_nonce' ) ); ?>',
                            deactivation_reason: deactivation_reason
                        },
                        success:function(response){
                            window.location.replace(deactivate_url);
                        }
                });
                return true;
            });

            jQuery('#jltunik-deactivate-survey-overlay').on('click', function () {
                jQuery('#jltunik-deactivate-survey-overlay').removeClass('jltunik-deactivate-survey-is-visible');
                jQuery('#jltunik-deactivate-survey-modal').removeClass('jltunik-deactivate-survey-is-visible');
            });
        </script>
        <?php
    }

}