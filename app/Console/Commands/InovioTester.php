<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Plustelecom\Inovio\Inovio;

class InovioTester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:ino-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test inovio end points';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->user = User::find(1);

//        $this->testTESTAUTH();
//        $this->testTESTGW();
//        $this->testTokenRequest();
//        $this->testCCAUTHCAP();
//        $this->testCCAUTHORIZE();
//        $this->testCCCAPTURE();
//        $this->testCCCAPTURE();
//        $this->testCCREVERSE();
//        $this->testCCSTATUS();
//        $this->testRecurring();
        $this->testSubscribe();
//        $this->testCancelSubscription();
    }

    private function testTESTAUTH() {
        $response = Inovio::authenticate();
        dd($response);
    }
    private function testTESTGW() {
        $response = Inovio::checkServiceAvailability();
        dd($response);
    }

    private function testTokenRequest() {
        $response = $this->user->createCardToken('4111111111111111');
        dd($response);
    }

    private function testCCAUTHORIZE() {
        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->preauthCharge($data);
        dd($response);

    }

    private function testCCAUTHCAP() {

        $data = [
            'cust_fname' => 'John', // optional
            'cust_lname' => 'Doe', // ptional
            'cust_email' => 'user5@example.com', // optional
            'cust_login' => 'username1', //optional
            'cust_password' => '12345678Xx', //optional
            'cust_password' => '12345678Xx', //optional
            'xtl_cust_id' => 'c777777777', //Merchant’s Customer ID, // optional
            'xtl_order_id' => 'abc123', //Merchant’s Order ID, // optional
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'bill_addr' => '123 Main Street Apt. 1', // Optional (address fields may be required by the bank)
            'bill_addr_city' => 'Los Angeles', // Optional (address fields may be required by the bank)
            'bill_addr_state' => 'CA', // Optional (some processors may require a valid 2-letter state or territory code)
            'bill_addr_zip' => 'CA', // Optional (address fields may be required by the bank)
            'bill_addr_country' => 'US', // Optional (address fields may be required by the bank), 2-letter Country Code ISO 3166-1 alpha-2
            'pmt_numb' => '4111111111111111', // Credit Card Number
            'pmt_key' => '123', // Credit Card CVV2 or CVC2 Code
            'pmt_expiry' => '12/2020', // Credit Card Expiration Date
        ];

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'pmt_numb' => '4111111111111111', // Credit Card Number
            'pmt_key' => '123', // Credit Card CVV2 or CVC2 Code
            'pmt_expiry' => '12/2020', // Credit Card Expiration Date
        ];

        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->charge($data);
        dd($response);
    }

    private function testCCCAPTURE() {

        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->preauthCharge($data); // step 1

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 5.06,
            'request_ref_po_id' => $response['PO_ID'],
        ];

        $response = $this->user->captureCharge($data);  // step 2
        dd($response);
    }

    private function testCCREVERSE() {
        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->preauthCharge($data); // step 1

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'request_ref_po_id' => $response['PO_ID'],
        ];

        $response = $this->user->reverseAuth($data);  // step 2
        dd($response);
    }

    private function testCCSTATUS() {
        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->preauthCharge($data); // step 1

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'request_ref_po_id' => $response['PO_ID'],
        ];

        $response = Inovio::checkOrderStatus($data);
        dd($response);
    }

    private function testRecurring() {
        $token = $this->user->createCardToken('4111111111111111');

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'token_guid' => $token['TOKEN_GUID'],
        ];

        $response = $this->user->preauthCharge($data);

        $data = [
            'li_prod_id_1' => 85098, // Line Item Product ID 1
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'cust_id' => $response['CUST_ID'], // Send a simple Recurring Transaction request by keying off the CUST_ID parameter from the original authorization.
        ];

        $response = $this->user->charge($data);
        dd($response);
    }

    private function testSubscribe() {

//        $token = $this->user->createCardToken('4111111111111111');
//
//        $data = [
//            'li_prod_id_1' => 85098, // configured to support membership
//            'li_value_1' => 19.95,
//            'li_count_1' => 1,
//            'token_guid' => $token['TOKEN_GUID'],
//        ];

        $data = [
            'li_prod_id_1' => 85098, // configured to support membership
            'li_value_1' => 19.95,
            'li_count_1' => 1,
            'pmt_numb' => '4111111111111111', // Credit Card Number
            'pmt_key' => '123', // Credit Card CVV2 or CVC2 Code
            'pmt_expiry' => '04/2020', // Credit Card Expiration Date
        ];

        $response = $this->user->subscribe(1, $data);
        dd($response);
    }

    private function testCancelSubscription() {
        $response = $this->user->cancelSubscription(2);
        dd($response);
    }
}
