<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Handles Peach Payment APIs
 * https://peachpayments.com/
*/
class Peach_Pay { 

    public function __construct() {

        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        define('PEACH_PAYOUT_CALLBACK_URL',base_url().'payment/payout_callback/');
    }

    //initiate curl request
    public function curl_request($endpoint, $headers=array(), $method='GET', $data='') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);

        if(!empty($headers)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);

        if(curl_errno($ch)) {
            return array('status'=> 'error', 'message'=>curl_error($ch), 'data'=>'');
        }

        curl_close($ch);
        return array('status'=> 'success', 'message'=>'Request success', 'data'=>$responseData);
    }

    /**
     * Peach: Store the data as stand-alone (Store user's Card info)
     * 
     * With COPYandPAY it is also possible to create a just registration 
     * separate from any later payment.
     * Perform a server-to-server POST request to prepare the checkout with the
     * required data for stroing card data createRegistration=true has to 
     * be sent. Response to a successful request is a JSON string with an id, 
     * which is required in the second step to create the payment form.
     * During the initial payment, marked by the parameter recurringType with
     * the value INITIAL, the customer is present.
     * 
     * @return    array $response Curl response with status and message
     * 
    */
    public function save_card() {

        $url  =  PEACH_CHECKOUT_URL;
        $data = "authentication.userId=" .PEACH_USER_ID.
                "&authentication.password=" .PEACH_PASSWORD.
                "&authentication.entityId=" .PEACH_ENTITY_ID.
                "&recurringType=INITIAL". //sending initial payment
                "&createRegistration=true";
        
        $r = $this->curl_request($url, $headers=array(), 'POST', $data);
        return $r;
    }

    /**
     * Peach: Get Stored data(Card) info
     * 
     * With save_card() you can store the payment data and using this method
     * we can get the stored card info using the checkout ID
    */ 
    public function get_card_status($checkout_id){

        $url  =  PEACH_CHECKOUT_URL.'/'.$checkout_id."/registration";
        $url .= "?authentication.userId=".PEACH_USER_ID;
        $url .= "&authentication.password=".PEACH_PASSWORD;
        $url .= "&authentication.entityId=".PEACH_ENTITY_ID;

        return $this->curl_request($url);
    }


    /**
     * Peach: Prepare the checkout (Send the request parameters 
     * server-to-server to prepare the payment form.)
     * 
     * Step-1: First, perform a server-to-server POST request to prepare the 
     * checkout with the required data, including the order type, amount and 
     * currency. The response to a successful request is a JSON string with an 
     * id, which is required in the second step to create the payment form.
     * 
     * @param     float $amount Stored registration ID in our DB
     * @param     string $currency  [ amount, currency, payment_type ]
     * @param     string string $peach_registration_id Stored registration ID
     * in our DB
     * @param     string $payment_type  (DB,PA)
     * @return    array $response Curl response with status and message
     * 
    */ 
    public function prepare_checkout($amount, $currency, $peachId,$payment_type='DB') {

        $allcard = "";
        for($i = 0; $i < count($peachId); $i++){
            $allcard .= "&registrations[$i].id=$peachId[$i]";
        }
        
        $url  =  PEACH_CHECKOUT_URL;
        $data = "authentication.userId=" .PEACH_USER_ID.
                "&authentication.password=" .PEACH_PASSWORD.
                "&authentication.entityId=" .PEACH_ENTITY_ID.
                "&amount=$amount" .
                "&currency=$currency" .
                $allcard.
                "&paymentType=$payment_type".
                "&createRegistration=true";
        $r = $this->curl_request($url, $headers=array(), 'POST', $data);
        return $r;
    }

    /**
     * Peach: Get the payment status (Find out if the payment was successful.)
     * 
     * Once the payment has been processed, the customer is redirected to your
     * `shopperResultUrl` along with a GET parameter resourcePath. Then, to get
     * the status of the payment, you should make a GET request to the 
     * baseUrl + resourcePath, including your authentication parameters.
     * 
     * @param     string $checkout_id The ID we get from successful 
     *            prepare_checkout() call
     * @return    array $response Curl response with status and message
     * 
    */
    public function get_payment_status($checkout_id) {

        $url  =  PEACH_CHECKOUT_URL.'/'.$checkout_id."/payment";
        $url .= "?authentication.userId=".PEACH_USER_ID;
        $url .= "&authentication.password=".PEACH_PASSWORD;
        $url .= "&authentication.entityId=".PEACH_ENTITY_ID;

        return $this->curl_request($url);
    }

    /**
     * Peach: Recurring- Repeated Payment
     * https://peachpayments.docs.oppwa.com/tutorials/server-to-server/
     * one-click-payment-guide
     * 
     * Any payment request following the initial one has to have the parameter
     * recurringType with the value REPEATED. This flag not only indicates that
     *  the request is part of a series of payments on this account, but also 
     * tells the payment system that no user is present and therefore 
     * parameters like card.cvv or the 3D authentication shouldn't be present.
     * 
     * @param     string $peach_registration_id Stored registration ID in our DB
     * @param     array $payment_data  [ amount, currency, payment_type ]
     * @return    array $response Curl response with status and message
     * 
    */
    public function charge_user($peach_registration_id, $payment_data) {

        $authorization = "Authorization: Bearer ".PEACH_BEARER_TOKEN;
        $headers = array($authorization);

        extract($payment_data);
        $url  =  PEACH_REGISTRATION_URL.$peach_registration_id.'/payments';
        $data = "entityId=" . PEACH_ENTITY_ID .
                "&amount=$amount" .
                "&currency=$currency" .
                "&paymentType=$payment_type" .
                "&recurringType=REPEATED";

        //echo $data; die;
        $r = $this->curl_request($url, $headers, 'POST', $data);
        return $r;
    }

    /**
     * Peach: Bank Payouts
     * 
     * A payments request will submit data relating to a payments batch.
     * A payments batch can be for Creditors, Salaries or Wages. Once a
     * payment batch has been submitted, a CDV check will be performed on
     * the account details provided and any accounts failing that check will
     * be included in the response. Any accounts that passed the CDV check will
     * continue to be processed.
     * 
     * @param $header_data = array()  [ due_date, reference ]
     * @param $payment_data = array()  [ first_name, sur_name, branch_code,
     * account_number, file_amount, amount_multiplier, payment_reference, 
     * records, amount, branch_hash, account_hash ]
     * @return    array $response Curl response with status and message
     * 
    */
    public function create_payout($header_data, $payment_data){
 
        $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'; 
        $url = PEACH_PAYOUT_URL."?key=".PEACH_API_KEY;
        
        extract($header_data);
        extract($payment_data);
        // log_event(json_encode($header_data));
        // log_event(json_encode($payment_data));

        $request = "<APIPaymentsRequest>
                        <Header>
                            <PsVer>".PEACH_VERSION."</PsVer>
                            <Client>".PEACH_CLIENT_CODE."</Client>
                            <DueDate>".$due_date."</DueDate>
                            <Service>".PEACH_SERVICE."</Service>
                            <ServiceType>".PEACH_SERVICE_TYPE."</ServiceType>
                            <Reference>".$reference."</Reference>
                            <CallBackUrl>".PEACH_PAYOUT_CALLBACK_URL."</CallBackUrl>
                        </Header>
                        <Payments>
                            <FileContents>
                                <FirstNames>".$first_name."</FirstNames>
                                <Surname>".$sur_name."</Surname>
                                <BranchCode>".$branch_code."</BranchCode>
                                <AccountNumber>".$account_number."</AccountNumber>
                                <FileAmount>".$file_amount."</FileAmount>
                                <AmountMultiplier>".$amount_multiplier."</AmountMultiplier>
                                <Reference>".$payment_reference."</Reference>
                            </FileContents>
                        </Payments>
                        <Totals>
                            <Records>".$records."</Records>
                            <Amount>".$amount."</Amount>
                            <BranchHash>".$branch_hash."</BranchHash>
                            <AccountHash>".$account_hash."</AccountHash>
                        </Totals>
                    </APIPaymentsRequest>";
                    
        $data = 'request='.$request; 
        return $this->curl_request($url, $headers, 'POST', $data);
    }

    /**
     * Peach: Backoffice operations - Refund a payment
     * 
     * A refund is performed against a previous payment, referencing its
     * payment.id by sending a POST request over HTTPS to the /payments/{id}
     * endpoint. A refund can be performed against debit (DB) or captured 
     * preauthorization (PA->CP) payment types. Where supported, the amount 
     * field can be used to process a partial or full amount.
     * https://peachpayments.docs.oppwa.com/tutorials/manage-payments/
     * backoffice#refund
     * 
     * @param     string $peach_payment_id payments generated using 
     *            COPYandPAY or server-to-server
     * @param     array $payment_data  [ amount, currency, payment_type ]
     * @return    array $response Curl response with status and message
     * 
    */
    public function refund_payment($peach_payment_id, $payment_data) {

        $authorization = "Authorization: Bearer ".PEACH_BEARER_TOKEN;
        $headers = array($authorization);

        extract($payment_data);
        $url  =  PEACH_PAYMENT_URL.'/'.$peach_payment_id;
        $data = "entityId=" . PEACH_ENTITY_ID .
                "&amount=$amount" .
                "&currency=$currency" .
                "&paymentType=$payment_type";

        //echo $data; die;
        $r = $this->curl_request($url, $headers, 'POST', $data);
        return $r;
    }

    /**
     * Peach: Deleting the stored payment data (Stored user's Card info)
     * 
     * Once stored, a token can be deleted using the HTTP DELETE method against
     * the registration.id
     * 
     * @param     string $peach_registration_id Stored registration ID in our DB
     * @return    array $response Curl response with status and message
     * 
    */
    public function remove_card($peach_registration_id) {

        $authorization = "Authorization: Bearer ".PEACH_BEARER_TOKEN;
        $headers = array($authorization);

        $url  =  PEACH_REGISTRATION_URL.$peach_registration_id;
        $url .= "?authentication.entityId=" .PEACH_ENTITY_ID;
        //echo $url; die;
        $r = $this->curl_request($url, $headers, 'DELETE');
        return $r;
    }

    public function prepare_mobile_checkout($amount, $currency, $payment_type='DB'){

        $url  =  PEACH_CHECKOUT_URL;
        $data = "authentication.userId=" .PEACH_USER_ID.
                "&authentication.password=" .PEACH_PASSWORD.
                "&authentication.entityId=" .PEACH_ENTITY_ID.
                "&amount=$amount" .
                "&currency=$currency" .
                "&paymentType=$payment_type";
        $r = $this->curl_request($url, $headers=array(), 'POST', $data);
        return $r;
    }
}