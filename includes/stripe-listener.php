<?php
    
    function pippin_stripe_event_listener() {
        
        if(isset($_GET['webhook-listener']) && $_GET['webhook-listener'] == 'stripe') {
            global $stripe_options;
            
            require_once(STRIPE_BASE_DIR . '/lib/Stripe.php');
            
            if(isset($stripe_options['test_mode']) && $stripe_options['test_mode']) {
                $secret_key = $stripe_options['test_secret_key'];
            } else {
                $secret_key = $stripe_options['live_secret_key'];
            }
            
            Stripe::setApiKey($secret_key);
            // retrieve the request's body and parse it as JSON
            $body = @file_get_contents('php://input');
            // grab the event information
            $event_json = json_decode($body);
            
            // this will be used to retrieve the event from Stripe
            //		$event_id = $event_json->id;
            
            if(isset($event_json->id)) {
                try {
                    $event_id = $event_json->id;
                    if(isset($stripe_options['test_mode']) && $stripe_options['test_mode']) {
                        $event_id = "evt_195XrgKoREGz8XvFbVmV38Dq";
                    }
                    
                    $event = Stripe_Event::retrieve($event_id);
                    $invoice = $event->data->object;
                    // failed payment
                    if($event->type == 'charge.failed') {
                        $stripe_customer = Stripe_Customer::retrieve($invoice->customer);
                        $metadata = $stripe_customer->metadata;
                        $name = 'there';
                        if(isset($metadata)) {
                            if(isset($metadata->first_name) ) {
                                $name = $metadata->first_name;
                            }
                            if(isset($metadata->full_name)){
                                $name = $metadata->full_name;
                            }
                            if(isset($metadata->name)){
                                $name = $metadata->name;
                            }
                        }
                        $email = $stripe_customer->email;
                        $subject = __('Payment Failure at The Board Club', 'pippin_stripe');
                        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: The Board Club <peter@newportboardclub.com>', 'Bcc: peter@newportboardclub.com');
                        $message = "<html>";
                        $message = "<div>Hi " . $name . ",</div><br>";
                        $message .= "<div>Don't worry, it's easy to fix.  We'll try your payment again in 3 days but you will need to update your card information in your account by following these steps: </div>";
                        $message .= "<ol><li>Go to: <a href=\"http://www.newportboardclub.com\">www.newportboardclub.com</a> and login to your account</li>";
                        $message .= "<li>Click \"View Your Account\"</li>";
                        $message .= "<li>On the left-hand side, click \"Update Billing Information\"</li></ol>";
                        $message .= "<div>If you have any questions, please contact Peter at <a href=\"tel:%28949%29%20375-2461\" value=\"+19493752461\" target=\"_blank\">(949) 375-2461</a>.</div><br>";
                        $message .= "<div><p>Thank you!</p>";
                        $message .= "<p>The Board Club</p></div></html>";
                        wp_mail($email, $subject, $message, $headers);
                        
                    }
                    
                    
                } catch (Exception $e) {
                    // something failed, perhaps log a notice or email the site admin
                }
            }
        }
    }
    add_action('init', 'pippin_stripe_event_listener');
