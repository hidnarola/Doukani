<?php

/*
  CURL is the main thing here, CURL will make request to paytabs server and get the response here.
 */
require 'Curl.php'; // thanks to https://github.com/php-curl-class/php-curl-class

use \Curl\Curl;

class PayTabs {

    public $response_code;
    public $merchant_email;
    public $secret_key;
    public $paypage_id;
    public $reference_number;
    public $refund_amount;
    public $refund_reason;
    public $transaction_id;
    public $site_url;
    public $return_url;
    public $title;
    public $cc_first_name;
    public $cc_last_name;
    public $cc_phone_number;
    public $phone_number;
    public $email;
    public $products_per_title;
    public $unit_price;
    public $quantity;
    public $total_price = 0; // used to sum all the prices 
    public $other_charges;
    public $amount;
    public $discount;
    public $currency;
    public $reference_no;
    public $ip_customer;
    public $ip_merchant;
    public $billing_address;
    public $state;
    public $city;
    public $postal_code;
    public $country;
    public $address_shipping;
    public $state_shipping;
    public $city_shipping;
    public $postal_code_shipping;
    public $country_shipping;
    public $msg_lang;
    public $cms_with_version;
    public $payment_reference;
    public $start_date;
    public $end_date;

    /*
      Contractor to initialize all the variables from config.php file, also to reset integer values.
     */

    public function __construct() {

        $this->merchant_email = PAY_TABS_MERCHANT_EMAIL;
        $this->secret_key = PAY_TABS_SECRET_KEY;
        $this->site_url = PAY_TABS_SITE_URL;
        $this->return_url = PAY_TABS_RETURN_URL;
        $this->ip_merchant = PAY_TABS_IP_MERCHANT;
        $this->cms_with_version = PAY_TABS_CMS_WITH_VERSION;
        $this->products_per_title = "";
        $this->unit_price = 0;
        $this->quantity = 0;
        $this->discount = 0;
        $this->other_charges = 0;
    }

    /*
      Validate function will return an array to show if the email and secret key are valid.
     */

    public function validate() {
        //die("hello");
        $response = $this->curl('validate');
        return $response;
    }

    /*
      is_valid is quick function to check if the email and secret key are valid, if valid return true
      else return false
     */

    public function is_valid() {
        if ($this->validate() == "valid") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
      Return last server response code for the last CURL call.
     */

    public function get_last_response_code() {
        return $this->response_code;
    }

    /*
      curl function will take the required action and connect to paytabs.com server
     */

    private function curl($action) {

        $fields = null;
        switch ($action) {
            case 'validate':
                $url = 'https://www.paytabs.com/apiv2/validate_secret_key';
                $fields = array(
                    'merchant_email' => urlencode($this->merchant_email),
                    'secret_key' => urlencode($this->secret_key)
                );

                break;
            case 'create_pay_page':
                $url = 'https://www.paytabs.com/apiv2/create_pay_page';

                $fields = array(
                    'merchant_email' => $this->merchant_email,
                    'secret_key' => $this->secret_key,
                    'site_url' => $this->site_url,
                    'return_url' => $this->return_url,
                    'title' => $this->title,
                    'cc_first_name' => $this->cc_first_name,
                    'cc_last_name' => $this->cc_last_name,
                    'cc_phone_number' => $this->cc_phone_number,
                    'phone_number' => $this->phone_number,
                    'email' => $this->email,
                    'products_per_title' => $this->products_per_title,
                    'unit_price' => $this->unit_price,
                    'quantity' => $this->quantity,
                    'other_charges' => $this->other_charges,
                    'amount' => $this->amount,
                    'discount' => $this->discount,
                    'reference_no' => $this->reference_no,
                    'currency' => $this->currency,
                    'ip_customer' => $this->ip_customer,
                    'ip_merchant' => $this->ip_merchant,
                    'billing_address' => $this->billing_address,
                    'state' => $this->state,
                    'city' => $this->city,
                    'postal_code' => $this->postal_code,
                    'country' => $this->country,
                    'address_shipping' => $this->address_shipping,
                    'state_shipping' => $this->state_shipping,
                    'city_shipping' => $this->city_shipping,
                    'postal_code_shipping' => $this->postal_code_shipping,
                    'country_shipping' => $this->country_shipping,
                    'msg_lang' => $this->msg_lang,
                    'cms_with_version' => $this->cms_with_version
                );
                break;

            case 'verify_payment':
                $url = 'https://www.paytabs.com/apiv2/verify_payment';
                $fields = array(
                    'merchant_email' => $this->merchant_email,
                    'secret_key' => $this->secret_key,
                    'payment_reference' => $this->payment_reference
                );

                break;
            case 'transactions_reports':

                $url = "https://www.paytabs.com/apiv2/transaction_reports";
                $fields = array(
                    'merchant_email' => $this->merchant_email,
                    'secret_key' => $this->secret_key,
                    'startdate' => $this->start_date,
                    'enddate' => $this->end_date
                );
                break;
            case 'refund_process':
                $url = 'https://www.paytabs.com/apiv2/refund_process';
                $fields = array(
                    'merchant_email' => $this->merchant_email,
                    'secret_key' => $this->secret_key,
                    'paypage_id' => $this->paypage_id,
                    'reference_number' => $this->reference_number,
                    'refund_amount' => $this->refund_amount,
                    'refund_reason' => $this->refund_reason,
                    'transaction_id' => $this->transaction_id
                );

                break;
            default:
                exit("NO CURL Option");
                break;
        }

        if ($fields != null) {
            $curl = new Curl();            
            $fields['merchant_email'] = $this->merchant_email;            
            $curl->post($url, $fields);
            
            if ($curl->error) {
                exit('Error: ' . $curl->errorCode . ': ' . $curl->errorMessage);
            } else {

                $this->response_code = $curl->response->response_code;
                $curl->close();
                return $curl->response;
            }
        } else {
            exit("Empty Fields");
        }
    }

    /*
      this function will add item to the order
     */

    public function add_item($name, $price, $quantity) {
        if ($this->products_per_title == "") { // first item
            $this->products_per_title = $name;
            $this->unit_price = $price;
            $this->quantity = $quantity;
            $this->total_price = $price * $quantity;
        } else { // rest of the item
            $this->products_per_title = $this->products_per_title . ' || ' . $name;
            $this->unit_price = $this->unit_price . ' || ' . $price;
            $this->quantity = $this->quantity . ' || ' . $quantity;
            $this->total_price = $this->total_price + ($price * $quantity);
        }
    }

    /*
      set_other_charges function will add extra charges to the order
     */

    public function set_other_charges($charges) {
        $this->other_charges = $charges;
    }

    /*
      set_discount function will add discount to the order, the value of discount should be positive number
     */

    public function set_discount($discount) {
        $this->discount = $discount;
    }

    /*
      create_pay_page function will call curl function and return array of
      -result
      -response_code
      -payment_url
      -p_id
     */

    public function create_pay_page() {
        $this->amount = $this->total_price + $this->other_charges;
        return($this->curl('create_pay_page'));
    }

    /*
      set_address function will set the user address, this is important since paytabs verify credit card number with user address.
      this function will set the shipping address and billing address.
     */

    public function set_address($billing_address, $state, $city, $postal_code, $country) {
        $this->billing_address = $billing_address;
        $this->state = $state;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->country = $country;

        // copy for shipping address 

        $this->address_shipping = $billing_address;
        $this->state_shipping = $state;
        $this->city_shipping = $city;
        $this->postal_code_shipping = $postal_code;
        $this->country_shipping = $country;
    }

    /*
      set_shipping_address will change the shipping address only in case it is different than the billing address
     */

    public function set_shipping_address($billing_address, $state, $city, $postal_code, $country) {

        $this->address_shipping = $billing_address;
        $this->state_shipping = $state;
        $this->city_shipping = $city;
        $this->postal_code_shipping = $postal_code;
        $this->country_shipping = $country;
    }

    /*
      set_customer function will set the customer info,
      - First Name
      - Last name
      - International phone code for his country e.g. 00973
      - Customer email
     */

    public function set_customer($fname, $lname, $int_phone, $phone, $email) {
        $this->cc_first_name = $fname;
        $this->cc_last_name = $lname;
        $this->cc_phone_number = $int_phone;
        $this->phone_number = $phone;
        $this->email = $email;
    }

    /*
      set_page_setting, this function will set page setting and get some information about the customer
      - title :Description or title of the transaction done by the customer
      - reference_no: number from your system to track the transaction
      - ip_cutomer: customer IP address
      - msg_lang: the  language of the page
     */

    public function set_page_setting($title, $reference_no, $currency, $ip_customer, $msg_lang) {
        $this->title = $title;
        $this->reference_no = $reference_no;
        $this->currency = $currency;
        $this->ip_customer = $ip_customer;
        $this->msg_lang = $msg_lang;
    }

    public function set_return_url($url) {
        $this->return_url = $url;
    }

    public function set_refund_process($paypage_id, $reference_number, $refund_amount, $refund_reason, $transaction_id) {
        $this->paypage_id = $paypage_id;
        $this->reference_number = $reference_number;
        $this->refund_amount = $refund_amount;
        $this->refund_reason = $refund_reason;
        $this->transaction_id = $transaction_id;
        $response = $this->curl('refund_process');
        return $response;
    }

    /*
      verify_payment function will take the returned payment reference from paytabs and return array with:
      -result : transaction response
      -response_code
      -pt_invoice_id
      -amount
      -currency
      -transaction_id
     */

    public function verify_payment($payment_reference) {
        $this->payment_reference = $payment_reference;
        $response = $this->curl('verify_payment');
        return $response;
    }

    /*
      get_transactions_reports this function will get start and end dates of the transactions than it will return :
      -transaction_result
      -response_code
      Note the date format should be dd-mm-YYYY e.g. 18-08-2015
     */

    public function get_transactions_reports($start_date, $end_date) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $response = $this->curl('transactions_reports');
        return ($response);
    }

    // helpful functions
    private function debug_to_console($data) {

        if (is_array($data))
            $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }

}

?>