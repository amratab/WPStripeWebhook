<?php

function ab_load_stripe_scripts() {

	global $stripe_options;
	
	// check to see if we are in test mode
	if(isset($stripe_options['test_mode']) && $stripe_options['test_mode']) {
		$publishable = $stripe_options['test_publishable_key'];
	} else {
		$publishable = $stripe_options['live_publishable_key'];
	}

}
add_action('wp_enqueue_scripts', 'ab_load_stripe_scripts');
