<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/*
**
** CUSTOMIZE BILLING AND SHIPPING CHECKOUT FEILDS
**
*/

add_filter('woocommerce_default_address_fields', 'custom_override_default_checkout_fields', 10, 1);
function custom_override_default_checkout_fields($address_fields)
{
    $address_fields['address_1']['placeholder'] = __('Street Address', 'woocommerce');
    $address_fields['address_2']['placeholder'] = __('Apt. or Unit No.', 'woocommerce');
    return $address_fields;
}
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{
    // remove labels
    //loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($fields[$category] as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
    //billing fields
    $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
    $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
    $fields['billing']['billing_company']['placeholder'] = 'Business Name';
    $fields['billing']['billing_address_1']['placeholder'] = 'Street Address';
    $fields['billing']['billing_address_2']['placeholder'] = 'Apt. or Suite Number';
    $fields['billing']['billing_city']['placeholder'] = 'City';
    $fields['billing']['billing_postcode']['placeholder'] = 'Zip/Postal Code';
    $fields['billing']['billing_phone']['placeholder'] = 'Phone Number';
    $fields['billing']['billing_email']['placeholder'] = 'Email Address';
    //shipping fields
    $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
    $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
    $fields['shipping']['shipping_company']['placeholder'] = 'Business Name';
    $fields['shipping']['shipping_address_1']['placeholder'] = 'Street Address';
    $fields['shipping']['shipping_address_2']['placeholder'] = 'Apt. or Suite Number';
    $fields['shipping']['shipping_city']['placeholder'] = 'City';
    $fields['shipping']['shipping_postcode']['placeholder'] = 'Zip/Postal Code';
    //checkout fields
    $fields['order']['order_comments']['placeholder'] = 'Special shipping and delivery instructions';
    unset($fields['order']['order_comments']['label']);

    return $fields;
}


// Hook in
add_filter('woocommerce_checkout_fields', 'choose_profile');

// Our hooked in function - $fields is passed via the filter!
function choose_profile($fields)
{
    $fields['billing']['choose_profile'] = array(
    'required'  => true,
    'class'     => array('profile_select'),
    'clear'     => true,
    'type'      => 'select',
     'options'     => array(
       '' => __('Choose a customer type'),
       'architect-designer' => __('Architect/Designer'),
       'professional-contractor' => __('Professional Contractor/Installer'),
       'general-contractor' => __('General Contractor'),
       'property-manager-commercial' => __('Property Manager/Owner - Commercial'),
       'property-manager-residentual' => __('Property Manager/Owner - Residential'),
       'diy-commercial' => __('DIY - Commercial'),
       'diy-residential' => __(' DIY - Residential')
        )//end of options
     );

    return $fields;
}
//* Process the checkout
 add_action('woocommerce_checkout_process', 'choose_profile_process');
 function choose_profile_process()
 {
     global $woocommerce;

     // Check if set, if its not set add an error.
     if ($_POST['choose_profile'] == "blank") {
         wc_add_notice('<strong>Please select a profile</strong>', 'error');
     }
 }
 //* Update the order meta with field value
 add_action('woocommerce_checkout_update_order_meta', 'choose_profile_update_order_meta');
 function choose_profile_update_order_meta($order_id)
 {
     if ($_POST['choose_profile']) {
         update_post_meta($order_id, 'choose_profile', esc_attr($_POST['choose_profile']));
     }
 }

//* Display field value on the order edition page
add_action('woocommerce_admin_order_data_after_billing_address', 'choose_profile_display_admin_order_meta', 10, 1);
function choose_profile_display_admin_order_meta($order)
{
    echo '<p><strong>'.__('Persona').':</strong> ' . get_post_meta($order->id, 'choose_profile', true) . '</p>';
}

//* Add selection field value to emails
add_filter('woocommerce_email_order_meta_keys', 'choose_profile_order_meta_keys');
function choose_profile_order_meta_keys($keys)
{
    $keys['Persona:'] = 'choose_profile';
    return $keys;
}
