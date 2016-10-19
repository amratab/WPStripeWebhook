# WPStripeWebhook
Wordpress stripe webhook plugin

Helps integrating stripe webhooks on wordpress. Base code is from [Pippins plugin](https://pippinsplugins.com/stripe-integration-part-6-payment-receipts/).

## Usage

Copy the complete folder WPStripeWebhook in wp-content/plugins.
Go to website admin page.
Activate the WP Stripe webhook plugin for plugins section.
After this Settings will start showing Stripe webhook settings section. Click on it.
In the page fill the stripe keys and check test mode option if you want to test the plugin.

## Important notes and suggestions

For live mode, add stripe webhook endpoint (stripe account -> settings -> account settings -> webhook) like this
https://yourdomain.com?webhook-listener=stripe

For testing locally on your machine, you can use [Ultrahook](http://www.ultrahook.com/). Its awesome!
Set up your keys and username and start ultrahook on your machine using:

ultrahook -k your_ultrahook_key stripe   8888
Add a webhook endpoint url in your stripe account similar to this:
http://stripe.your_ultrahook_username.ultrahook.com/your_wp_website_folder_name/stripe-listener.php?webhook-listener=stripe

And it should start working for you.
Also, you might see 404 in ultrahook console. Just ignore it.
I would suggest setting up debugging too. It really helps. For debugging, add these to your wp_config.php
define('WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );

After this, you should see a debug.log file in your wp-content folder and it will display errors and warnings and whatever you print using error_log()

## Author

Amrata Baghel, amrata.baghel@gmail.com
[Portfolio](https://justlikeyou.co.in)







