<?php
    /*
     Plugin Name: WP Stripe Webhook
     Plugin URI: https://github.com/amratab/WPStripeWebhook
     Description: A plugin to illustrate how to integrate Stripe Webhooks with WordPress
     Author: Amrata Baghel
     Author URI: http://justlikeyou.co.in
     COntributors: Sahil Dhankhar
     Version: 1.0
     */
    
    /**********************************
     * constants and globals
     **********************************/
    
    if(!defined('STRIPE_BASE_URL')) {
        define('STRIPE_BASE_URL', plugin_dir_url(__FILE__));
    }
    if(!defined('STRIPE_BASE_DIR')) {
        define('STRIPE_BASE_DIR', dirname(__FILE__));
    }
    
    $stripe_options = get_option('stripe_settings');
    
    /*******************************************
     * plugin text domain for translations
     *******************************************/
    
    load_plugin_textdomain( 'ab_stripe', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    
    /**********************************
     * includes
     **********************************/
    if(is_admin()) {
        // load admin includes
        include(STRIPE_BASE_DIR . '/includes/settings.php');
    } else {
        // load front-end includes
        include(STRIPE_BASE_DIR . '/includes/scripts.php');
        include(STRIPE_BASE_DIR . '/includes/stripe-listener.php');
    }
    
    
