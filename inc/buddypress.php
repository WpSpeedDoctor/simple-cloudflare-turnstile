<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if(get_option('cfturnstile_bp_register')) {
	
	// Get turnstile field: BuddyPress
	add_action('bp_before_registration_submit_buttons','cfturnstile_field_bp_login');
	function cfturnstile_field_bp_login() { cfturnstile_field_show('#buddypress #signup-form .submit', 'turnstileBPCallback'); }

	// BuddyPress Register Check
	add_action('bp_signup_validate', 'cfturnstile_bp_register_check', 10, 1);
	function cfturnstile_bp_register_check(){
		if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['cf-turnstile-response'] ) ) {
			$check = cfturnstile_check();
			$success = $check['success'];
			if($success != true) {
				wp_die( '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Please verify that you are human.', 'simple-cloudflare-turnstile' ) . '</p>', 'simple-cloudflare-turnstile', array( 'response'  => 403, 'back_link' => 1, ) );
			}
		} else {
			wp_die( '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Please verify that you are human.', 'simple-cloudflare-turnstile' ) . '</p>', 'simple-cloudflare-turnstile', array( 'response'  => 403, 'back_link' => 1, ) );
		}
	}
	
}