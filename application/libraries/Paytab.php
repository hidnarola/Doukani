<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('PayTabs/PayTabs.php');

class Paytab {

    function check_secret_key() {
        $paytabs = new PayTabs();
        return $paytabs->validate();
    }

    function create_payment_page($request_data) {

        $paytabs = new PayTabs();
//        $result = $paytabs->verify_payment('200136');
//        print_r($result);
//        die();

        /*
          -title: payment title
          -ref_number: number from your system to track the order
          -currency: 3 character for currency
          -customer_ip: customer ip address
          -page_language: the language of the payment page

         */
        $client_ip_address = $this->getRealIpAddr();
        $paytabs->set_page_setting($request_data['title'], $request_data['reference_no'], 'AED', $client_ip_address, 'English');

        /*
          -customer first name
          -customer last name
          -customer international phone number
          -customer phone number
          -customer email

         */
        $paytabs->set_customer($request_data['cc_first_name'], $request_data['cc_last_name'], $request_data['cc_phone_number'], $request_data['cc_phone_number'], $request_data['email']);

        /*
          -Item name
          -item price in the same currency set in paytabs_config.php file
          -item quantity
         */
        if (isset($request_data['products']) && sizeof($request_data['products']) > 0) {
            foreach ($request_data['products'] as $product) {
                $paytabs->add_item($product['name'], $product['price'], $product['quantity']);
            }
        }
        /*
          add extra charges
         */

        $paytabs->set_other_charges($request_data['shipping_cost']);

        /*
          add discount
         */
        $paytabs->set_discount(0);

        /*
          -customer address
          -customer state, required for USA and Canada
          -customer city
          -customer postal code
          -customer country
         */
        $paytabs->set_address($request_data['billing_address'], $request_data['state'], $request_data['city'], $request_data['postal_code'], $request_data['country']);


        /*

          note: only set shipping address if it is different than billing address.
          -customer address
          -customer state, required for USA and Canada
          -customer city
          -customer postal code
          -customer country
         */
        $paytabs->set_shipping_address($request_data['billing_address'], $request_data['state'], $request_data['city'], $request_data['postal_code'], $request_data['country']);

        $paytabs->set_return_url($request_data['return_url']);

        /*
          return value:
          -result
          -response_code
          -payment_url
          -p_id
         */
        return $paytabs->create_pay_page();
    }

    function verify_payment($payment_reference) {
        $paytabs = new PayTabs();
        return $paytabs->verify_payment($payment_reference);
    }

    function refund_process($request_data) {
        $paytabs = new PayTabs();
        return $paytabs->set_refund_process($request_data['paypage_id'], $request_data['reference_number'], $request_data['refund_amount'], $request_data['refund_reason'], $request_data['transaction_id']);
    }

    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
