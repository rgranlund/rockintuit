<?php

/*
 * Add Additional Fields to Woo Registration
 */

function duraamen_extra_register_fields()
{
    ?>

    <p class="form-row form-row-first">

        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" placeholder="First Name" value="<?php if (!empty($_POST['billing_first_name'])) {
        esc_attr_e($_POST['billing_first_name']);
    } ?>" />
    </p>
    <p class="form-row form-row-last">

        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" placeholder="Last Name" value="<?php if (!empty($_POST['billing_last_name'])) {
        esc_attr_e($_POST['billing_last_name']);
    } ?>" />
    </p>
        <?php
    woocommerce_form_field(
        'title',
        array(
                'type' => 'text',
                'required' => false, // just adds an "*"
                'placeholder' => 'Title',
            ),
        (isset($_POST['title']) ? $_POST['title'] : ''),
    ); ?>
    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_company" id="reg_billing_company" placeholder="Company" value="<?php esc_attr_e($_POST['billing_company']); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" placeholder="Billing Address" value="<?php esc_attr_e($_POST['billing_address_1']); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_address_2" id="reg_billing_address_2" placeholder="Billing Address 2" value="<?php esc_attr_e($_POST['billing_address_2']); ?>" />
    </p>
        <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_city" id="reg_billing_city" placeholder="Billing City" value="<?php esc_attr_e($_POST['billing_city']); ?>" />
    </p>
        <p class="form-row form-row-wide">

        <input type="text" class="input-text" name="billing_state" id="reg_billing_state" placeholder="Billing State" value="<?php esc_attr_e($_POST['billing_state']); ?>" />
    </p>
        <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" placeholder="Zip" value="<?php esc_attr_e($_POST['billing_postcode']); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" placeholder="Phone" value="<?php esc_attr_e($_POST['billing_phone']); ?>" />
    </p>
    <div class="clear"></div>
    <?php

    woocommerce_form_field(
        'personal_interest',
        array(
                'type' => 'select',
                'required' => true, // just adds an "*"
                'options' => array(
                    '' => __('Choose a customer type'),
                    'architect-designer' => __('Architect/Designer'),
                    'professional-contractor' => __('Professional Contractor/Installer'),
                    'general-contractor' => __('General Contractor'),
                    'property-manager-commercial' => __('Property Manager/Owner - Commercial'),
                    'property-manager-residentual' => __('Property Manager/Owner - Residential'),
                    'diy-commercial' => __('DIY - Commercial'),
                    'diy-residential' => __(' DIY - Residential')
                ),
            ),
        (isset($_POST['personal_interest']) ? $_POST['personal_interest'] : ''),
    );
}

add_action('woocommerce_register_form_start', 'duraamen_extra_register_fields');

function duraamen_validate_extra_register_fields($username, $email, $validation_errors)
{
    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
        $validation_errors->add('billing_first_name_erro', __('First Name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
        $validation_errors->add('billing_last_name_error', __('Last Name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_email']) && empty($_POST['billing_email'])) {
        $validation_errors->add('billing_email_error', __('Email is required!', 'woocommerce'));
    }
    if (isset($_POST['personal_interest']) && empty($_POST['personal_interest'])) {
        $validation_errors->add('personal_interest_error', __('Personal Interest is required!', 'woocommerce'));
    }

    return $validation_errors;
}

add_action('woocommerce_register_post', 'duraamen_validate_extra_register_fields', 10, 3);


function duraamen_save_extra_register_fields($customer_id)
{
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'account_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    if (isset($_POST['billing_email'])) {
        update_user_meta($customer_id, 'billing_email', sanitize_text_field($_POST['billing_email']));
    }
    if (isset($_POST['billing_company'])) {
        update_user_meta($customer_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
    }
    if (isset($_POST['billing_address_1'])) {
        update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
    if (isset($_POST['billing_address_2'])) {
        update_user_meta($customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
    }
    if (isset($_POST['billing_city'])) {
        update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (isset($_POST['billing_state'])) {
        update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
    }
    if (isset($_POST['billing_phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
    if (isset($_POST['billing_postcode'])) {
        update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
    }
    if (isset($_POST['title'])) {
        update_user_meta($customer_id, 'title', sanitize_text_field($_POST['title']));
    }
    if (isset($_POST['personal_interest'])) {
        update_user_meta($customer_id, 'personal_interest', sanitize_text_field($_POST['personal_interest']));
    }
}

add_action('woocommerce_created_customer', 'duraamen_save_extra_register_fields');
/*
 * END  Additional Fields to Woo Registration
 */