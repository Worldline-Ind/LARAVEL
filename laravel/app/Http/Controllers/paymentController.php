<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use DateInterval;

class paymentController extends Controller
{
    public function index()
    {
       $path = storage_path() . "/json/worldline_AdminData.json";
       $mer_array = json_decode(file_get_contents($path), true);

       return view('paymentpage',compact('mer_array'));
    }

    public function payProcess(Request $request)
    {
       $path = storage_path() . "/json/worldline_AdminData.json";
       $mer_array = json_decode(file_get_contents($path), true);
        
       if($mer_array['typeOfPayment'] == "TEST")
       {
          $request->amount = 1;
       }

      if($mer_array['enableEmandate'] == 1 && $mer_array['enableSIDetailsAtMerchantEnd'] == 1){
         $request->debitStartDate = date('d-m-Y');
         $request->debitEndDate = date('d-m-Y', strtotime($request->debitStartDate ));
      }

   
      if($mer_array['enableEmandate'] == 1){
         $amt = $request->amount;
         $request->maxAmount = $amt *2;
     } 



       $datastring = $request->marchantId . "|" . $request->txnId . "|" . $request->amount . "|" . "|" . $request->consumerId . "|" . $request->mobileNumber . "|" . $request->email . "||||||||||" . $request->salt;
      
      if($mer_array['enableEmandate'] == 1){
         $datastring = $request->marchantId . "|" . $request->txnId . "|" . $request->amount . "|" . "|" . $request->consumerId . "|" . $request->mobileNumber . "|" . $request->email . "||||||||||" . $request->salt;
      }
      if($mer_array['enableEmandate'] == 1 && $mer_array['enableSIDetailsAtMerchantEnd'] == 1 ) 
      {
         $datastring = $request->marchantId."|".$request->txnId."|".$request->amount."|".$request->accNo."|".$request->consumerId."|".$request->mobileNumber."|".$request->email."|".$request->debitStartDate."|".$request->debitEndDate."|".$request->maxAmount."|".$request->amountType."|".$request->frequency."|".$request->cardNumber."|".$request->expMonth."|".$request->expYear."|".$request->cvvCode."|".$request->salt;
      }
      
        $hashVal = hash('sha512', $datastring);
        $paymentDetails = array(
            'marchantId' => $request->marchantId,
            'txnId' => $request->txnId,
            'amount' => $request->amount,
            'currencycode' => $request->currencycode,
            'schemecode' => $request->schemecode,
            'consumerId' => $request->consumerId,
            'mobileNumber' => $request->mobileNumber,
            'email' => $request->email,
            'customerName' => $request->customerName,
            'accNo' => $request->accNo,
            'accountName' => $request->accountName,
            'aadharNumber' => $request->aadharNumber,
            'ifscCode' => $request->ifscCode, 
            'accountType' => $request->accountType,
            'debitStartDate' => $request->debitStartDate,
            'debitEndDate' => $request->debitEndDate, 
            'maxAmount' => $request->maxAmount, 
            'amountType' => $request->amountType,   
            'frequency' => $request->frequency,
            'cardNumber' => $request->cardNumber, 
            'expMonth' => $request->expMonth, 
            'expYear' => $request->expYear,     
            'cvvCode' => $request->cvvCode,        
            'hash' => $hashVal
        );
        return view('checkoutpage', ['payval' => $paymentDetails],compact('mer_array'));
    }

    public function checkout(Request $request)
    {
        $response = $request->msg;
        $res_msg = explode("|",$_POST['msg']);
      
        $path = storage_path() . "/json/worldline_AdminData.json";
        $mer_array = json_decode(file_get_contents($path), true); 
        date_default_timezone_set('Asia/Calcutta');
         $strCurDate = date('d-m-Y');


        $arr_req = array(
            "merchant" => ["identifier" => $mer_array['merchantCode'] ],
            "transaction" => [ "deviceIdentifier" => "S","currency" => $mer_array['currency'],"dateTime" => $strCurDate,
            "token" => $res_msg[5],"requestType" => "S"]
        );

        $finalJsonReq = json_encode($arr_req);

        function callAPI($method, $url, $finalJsonReq)
        {
           $curl = curl_init();
           switch ($method)
           {
              case "POST":
                 curl_setopt($curl, CURLOPT_POST, 1);
                 if ($finalJsonReq)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                 break;
              case "PUT":
                 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                 if ($finalJsonReq)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                 break;
              default:
                 if ($finalJsonReq)
                    $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
           }
           // OPTIONS:
           curl_setopt($curl, CURLOPT_URL, $url);
           curl_setopt($curl, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
           ));
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
           curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
           // EXECUTE:
           $result = curl_exec($curl);
           
           if(!$result){die("Connection Failure !! Try after some time.");}
           curl_close($curl);
           return $result;
        }

        $method = 'POST';
        $url = "https://www.paynimo.com/api/paynimoV2.req";
        $res_result = callAPI($method, $url, $finalJsonReq);
        $dualVerifyData = json_decode($res_result, true);

        return view('responsepage',compact('response','res_msg','dualVerifyData'));
    }

    public function offline_request(Request $request)
    {
         $identifier = $_POST['transactionIdentifier'];
         $date = $_POST['transactionDate'];
         $newDate = date("d-m-Y", strtotime($date));
      
         $path = storage_path() . "/json/worldline_AdminData.json";
         $mer_array = json_decode(file_get_contents($path), true); 
      
         $arr_req = array(
             "merchant" => [
                 "identifier" => $mer_array['merchantCode']
             ],
             "transaction" => [ "deviceIdentifier" => "S", "currency" => $mer_array['currency'], "identifier" => $identifier, "dateTime" => $newDate, "requestType" => "O"]
         );
      
         $finalJsonReq = json_encode($arr_req);
      
          function callAPI($method, $url, $finalJsonReq)
          {
             $curl = curl_init();
             switch ($method){
                case "POST":
                   curl_setopt($curl, CURLOPT_POST, 1);
                   if ($finalJsonReq)
                      curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                   break;
                case "PUT":
                   curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                   if ($finalJsonReq)
                      curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                   break;
                default:
                   if ($finalJsonReq)
                      $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
             }
             // OPTIONS:
             curl_setopt($curl, CURLOPT_URL, $url);
             curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
             ));
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
             curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
             // EXECUTE:
             $result = curl_exec($curl);
             if(!$result){die("Connection Failure !! Try after some time.");}
             curl_close($curl);
             return $result;
          }
      
          $method = 'POST';
          $url = "https://www.paynimo.com/api/paynimoV2.req";
          $res_result = callAPI($method, $url, $finalJsonReq);
          $offlineVerifyData = json_decode($res_result, true);

          return view('offline_request',compact('offlineVerifyData'));
      }

      public function reconcile_request(Request $request)
      {
         try{
            set_time_limit(300);
            $identifier = trim($_POST['transactionIdentifier']);
            $identifierArray = explode(',', $identifier);
            $startDate = new \DateTime($_POST['fromtransactionDate']);
            $endDate = clone $startDate;
            $endDate->modify($_POST['totransactionDate'].' +1 day');
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($startDate, $interval, $endDate);
            foreach ($period as $date) {
               $dates[] = $date->format('d-m-Y');
           }
         
           $path = storage_path() . "/json/worldline_AdminData.json";
           $mer_array = json_decode(file_get_contents($path), true); 
         
             function callAPI($method, $url, $finalJsonReq)
             {
                $curl = curl_init();
                switch ($method){
                   case "POST":
                      curl_setopt($curl, CURLOPT_POST, 1);
                      if ($finalJsonReq)
                         curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                      break;
                   case "PUT":
                      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                      if ($finalJsonReq)
                         curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                      break;
                   default:
                      if ($finalJsonReq)
                         $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
                }
                // OPTIONS:
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                   'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                // EXECUTE:
                $result = curl_exec($curl);
                if(!$result){die("Connection Failure !! Try after some time.");}
                curl_close($curl);
                return $result;
             }
         
             $method = 'POST';
             $url = "https://www.paynimo.com/api/paynimoV2.req";
             $success_statusCode = [];
             $failure_statusCode = [];
             foreach ($identifierArray as $id) {
               foreach ($dates as $date) {
                 $arr_req = array(
                     "merchant" => [
                         "identifier" => $mer_array['merchantCode']
                     ],
                     "transaction" => [ "deviceIdentifier" => "S", "currency" => $mer_array['currency'], "identifier" => $id, "dateTime" => $date, "requestType" => "O"]
                 );
                 $finalJsonReq = json_encode($arr_req);
                 $res_result = callAPI($method, $url, $finalJsonReq);
                 $reconciliationData = json_decode($res_result, true);
                 if($reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"] == '9999'){
                    $statusCode = $reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"];
                 }
                 if ($reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"] == '0300'){
                    if(!(isset($success)&&!empty($success))){
                      $success_statusCode[] = $reconciliationData;
                      break;
                    }
                    $success = $reconciliationData;
                 }
               }
               if(!empty($statusCode) && ($reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"] == '9999')|| ($reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"] == '0399')){
                $failure_statusCode[] = $reconciliationData;
               }
             }
            }
            catch(\Exception $e) {
               return back()->withError('Select dates properly');
            }
             return view('reconcile_request')->with(compact('success_statusCode','failure_statusCode'));
        }

        public function refund_request(Request $request)
         {
            $token = $_POST['transactionIdentifier'];
            $amount = $_POST['amount'];
            $date = $_POST['transactionDate'];
            $newDate = date("d-m-Y", strtotime($date));

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true); 

            $arr_req = array(
               "merchant" => [
                   "identifier" => $mer_array['merchantCode']
               ],
              "cart" => [ "" => ""
              ],
               "transaction" => [ "deviceIdentifier" => "S", "amount" => $amount, "currency" => $mer_array['currency'], "dateTime" => $newDate, "token" => $token, "requestType" => "R"]
           );
           $finalJsonReq = json_encode($arr_req);

            function callAPI($method, $url, $finalJsonReq)
            {
               $curl = curl_init();
               switch ($method){
                  case "POST":
                     curl_setopt($curl, CURLOPT_POST, 1);
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                     break;
                  case "PUT":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                     break;
                  default:
                     if ($finalJsonReq)
                        $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
               }
               // OPTIONS:
               curl_setopt($curl, CURLOPT_URL, $url);
               curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
               ));
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
               curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
               // EXECUTE:
               $result = curl_exec($curl);
               if(!$result)
               {
                     die("Connection Failure !! Try after some time.");
               }
               curl_close($curl);
               return $result;
            }
            $method = 'POST';
            $url = "https://www.paynimo.com/api/paynimoV2.req";
            $res_result = callAPI($method, $url, $finalJsonReq);
            $refundData = json_decode($res_result, true);

            
               return view('refund_request',compact('refundData'));
         }

         public function mandate_verification_request(Request $request)
         {
            $type                      = $_POST['type'];
            $merchantTransactionID     = $_POST['merchantTransactionID'];
            $consumerTransactionID     = $_POST['consumerTransactionID'];
            $date                      = $_POST['transactionDate'];
            $newDate                   = date("d-m-Y", strtotime($date));

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true); 
            
            $arr_req = array(
               "merchant" => [
                   "identifier" => $mer_array['merchantCode']
               ],
              "payment" => ["instruction" => [ "" => "" ]
              ],
               "transaction" => [ "deviceIdentifier" => "S", "type" => $type, "currency" => $mer_array['currency'], "identifier" => $merchantTransactionID, "dateTime" => $newDate, "subType" => "002", "requestType" => "TSI"],        
              "consumer" => [ "identifier" => $consumerTransactionID
              ]
           );
           $finalJsonReq = json_encode($arr_req);
           function callAPI($method, $url, $finalJsonReq)
            {
               $curl = curl_init();
               switch ($method){
                     case "POST":
                        curl_setopt($curl, CURLOPT_POST, 1);
                        if ($finalJsonReq)
                           curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                        break;
                     case "PUT":
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                        if ($finalJsonReq)
                           curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                        break;
                     default:
                        if ($finalJsonReq)
                           $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
               }
               // OPTIONS:
               curl_setopt($curl, CURLOPT_URL, $url);
               curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
               ));
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
               curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
               // EXECUTE:
               $result = curl_exec($curl);
               if(!$result)
               {
                     die("Connection Failure !! Try after some time.");
               }
               curl_close($curl);
               return $result;
            }

            $method = 'POST';
            $url = "https://www.paynimo.com/api/paynimoV2.req";
            $res_result = callAPI($method, $url, $finalJsonReq);
            $verifyData = json_decode($res_result, true);
            
            return view('mandate_verification_request',compact('verifyData'));
         }

         public function transaction_scheduling_request(Request $request)
         {
            $transactionIdentifier = str_shuffle("0123456789");
            $date = date("dmY", strtotime($_POST['transactionDate']));  

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true);

            $arr_req = array(
               "merchant" => [
                 "identifier" => $mer_array['merchantCode']
               ],
              "payment" => [
                "instrument" => [
                  "identifier" => $mer_array['merchantSchemeCode']
                ],
                "instruction" => [
                  "amount"=> $_POST['amount'],
                  "endDateTime"=> $date,
                  "identifier"=> $_POST['mandateRegistrationId']
                ]
              ],
               "transaction" => [ 
                "deviceIdentifier" => "S",
                "type" => $_POST['transactionType'],
                "currency" => $mer_array['currency'],
                "identifier" => $transactionIdentifier,
                "subType" => "003",
                "requestType" => "TSI"
              ]
           ); 
           $finalJsonReq = json_encode($arr_req);
           function callAPI($method, $url, $finalJsonReq)
            {
               $curl = curl_init();
               switch ($method){
                  case "POST":
                     curl_setopt($curl, CURLOPT_POST, 1);
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                     break;
                  case "PUT":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                     break;
                  default:
                     if ($finalJsonReq)
                        $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
               }
               // OPTIONS:
               curl_setopt($curl, CURLOPT_URL, $url);
               curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json',
               ));
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
               curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
               // EXECUTE:
               $result = curl_exec($curl);
               if(!$result){die("Connection Failure !! Try after some time.");}
               curl_close($curl);
               return $result;
            }
            $method = 'POST';
            $url = "https://www.paynimo.com/api/paynimoV2.req";
            $res_result = callAPI($method, $url, $finalJsonReq);
            $schedulingData = json_decode($res_result, true);
            
            
          return view('transaction_scheduling_request',compact('schedulingData'));
         }

         public function transaction_verification_request(Request $request)
         {
            $merchantTransactionID     = $_POST['merchantTransactionID'];
            $date                      = $_POST['transactionDate'];
            $newDate                   = date("d-m-Y", strtotime($date)); 

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true);
            $arr_req = array(
               "merchant" => [
                   "identifier" => $mer_array['merchantCode']
               ],
              "payment" => ["instruction" => [ "" => "" ]
              ],
               "transaction" => [ "deviceIdentifier" => "S", "type" => $_POST['type'], "currency" => $mer_array['currency'], "identifier" => $_POST['merchantTransactionID'], "dateTime" => $date, "subType" => "004", "requestType" => "TSI"]
           );
      
         $finalJsonReq = json_encode($arr_req);
         function callAPI($method, $url, $finalJsonReq)
         {
            $curl = curl_init();
            switch ($method){
                  case "POST":
                     curl_setopt($curl, CURLOPT_POST, 1);
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                     break;
                  case "PUT":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                     break;
                  default:
                     if ($finalJsonReq)
                        $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
            }
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
               'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result)
            {
                  die("Connection Failure !! Try after some time.");
            }
            curl_close($curl);
            return $result;
         }

         $method = 'POST';
         $url = "https://www.paynimo.com/api/paynimoV2.req";
         $res_result = callAPI($method, $url, $finalJsonReq);
         $verifyData = json_decode($res_result, true);
            
          return view('transaction_verification_request',compact('verifyData'));
         }


         public function mandate_deactivation_request(Request $request)
         {
            $type                      = $_POST['type'];
            $mandateRegistrationID     = $_POST['mandateRegistrationID'];
            $transactionIdentifier     = rand(1,100000000);

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true);

            $arr_req = array(
               "merchant" => [
                   "webhookEndpointURL" => "",
                  "responseType" => "",
                  "responseEndpointURL" => "",
                  "description" => "",
                  "identifier" => $mer_array['merchantCode'],
                  "webhookType" => ""
               ],
              "cart" => [
                  "item" => [
                      [
                          "description" => "",
                          "providerIdentifier" => "",
                          "surchargeOrDiscountAmount" => "",
                          "amount" => "",
                          "comAmt" => "",
                          "sKU" => "",
                          "reference" => "",
                          "identifier" => ""
                      ]
                  ],
                  "reference" => "",
                  "identifier" => "",
                  "description" => "",
                  "Amount" => ""
              ],
              "payment" => [
                  "method" => [
                      "token" => "",
                      "type" => ""
                  ],
                  "instrument" => [
                      "expiry" => [
                          "year" => "",
                          "month" => "",
                          "dateTime" => ""
                      ],
                      "provider" => "",
                      "iFSC" => "",
                      "holder" => [
                          "name" => "",
                          "address" => [
                              "country" => "",
                              "street" => "",
                              "state" => "",
                              "city" => "",
                              "zipCode" => "",
                              "county" => ""
                          ]
                      ],
                      "bIC" => "",
                      "type" => "",
                      "action" => "",
                      "mICR" => "",
                      "verificationCode" => "",
                      "iBAN" => "",
                      "processor" => "",
                      "issuance" => [
                          "year" => "",
                          "month" => "",
                          "dateTime" => ""
                      ],
                      "alias" => "",
                      "identifier" => "",
                      "token" => "",
                      "authentication" => [
                          "token" => "",
                          "type" => "",
                          "subType" => ""
                      ],
                      "subType" => "",
                      "issuer" => "",
                      "acquirer" => ""
                  ],
                  "instruction" => [
                      "occurrence" => "",
                      "amount" => "",
                      "frequency" => "",
                      "type" => "",
                      "description" => "",
                      "action" => "",
                      "limit" => "",
                      "endDateTime" => "",
                      "identifier" => "",
                      "reference" => "",
                      "startDateTime" => "",
                      "validity" => ""
                  ]
              ],
               "transaction" => [
                  "deviceIdentifier" => "S",
                  "smsSending" => "",
                  "amount" => "",
                  "forced3DSCall " => "",
                  "type" => $type,
                  "description" => "",
                  "currency" => $mer_array['currency'],
                  "isRegistration" => "",
                  "identifier" => $transactionIdentifier,
                  "dateTime" => "",
                  "token" => $mandateRegistrationID,
                  "securityToken" => "",
                  "subType" => "005",
                  "requestType" => "TSI",
                  "reference" => "",
                  "merchantInitiated" => "",
                  "merchantRefNo" => ""
              ],
              "consumer" => [
                  "mobileNumber" => "",
                  "emailID" => "",
                  "identifier" => "",
                  "accountNo" => ""
              ]
           );
      
         $finalJsonReq = json_encode($arr_req);
         function callAPI($method, $url, $finalJsonReq)
         {
            $curl = curl_init();
            switch ($method){
                  case "POST":
                     curl_setopt($curl, CURLOPT_POST, 1);
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                     break;
                  case "PUT":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                     break;
                  default:
                     if ($finalJsonReq)
                        $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
            }
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
               'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result)
            {
                  die("Connection Failure !! Try after some time.");
            }
            curl_close($curl);
            return $result;
         }
         $method = 'POST';
         $url = "https://www.paynimo.com/api/paynimoV2.req";
         $res_result = callAPI($method, $url, $finalJsonReq);
         $responseData = json_decode($res_result, true);
               
         return view('mandate_deactivation_request',compact('responseData'));
         }


         public function stop_payment_request(Request $request)
         {
            $transactionIdentifier = str_shuffle("0123456789");

            $path = storage_path() . "/json/worldline_AdminData.json";
            $mer_array = json_decode(file_get_contents($path), true);

            $arr_req = array(
               "merchant"=> [
              "webhookEndpointURL"=> "",
              "responseType"=> "",
              "responseEndpointURL"=> "",
              "description"=> "",
              "identifier"=> $mer_array['merchantCode'],
              "webhookType"=> ""
            ],
            "cart"=> [
              "item"=> [
                [
                  "description"=> "",
                  "providerIdentifier"=> "",
                  "surchargeOrDiscountAmount"=> "",
                  "amount"=> "",
                  "comAmt"=> "",
                  "sKU"=> "",
                  "reference"=> "",
                  "identifier"=> ""
                ]
              ],
              "reference"=> "",
              "identifier"=> "",
              "description"=> "",
              "Amount"=> ""
            ],
            "payment"=> [
              "method"=> [
                "token"=> "",
                "type"=> ""
              ],
              "instrument"=> [
                "expiry"=> [
                  "year"=> "",
                  "month"=> "",
                  "dateTime"=> ""
                ],
                "provider"=> "",
                "iFSC"=> "",
                "holder"=> [
                  "name"=> "",
                  "address"=> [
                    "country"=> "",
                    "street"=> "",
                    "state"=> "",
                    "city"=> "",
                    "zipCode"=> "",
                    "county"=> ""
                  ]
                ],
                "bIC"=> "",
                "type"=> "",
                "action"=> "",
                "mICR"=> "",
                "verificationCode"=> "",
                "iBAN"=> "",
                "processor"=> "",
                "issuance"=> [
                  "year"=> "",
                  "month"=> "",
                  "dateTime"=> ""
                ],
                "alias"=> "",
                "identifier"=> "",
                "token"=> "",
                "authentication"=> [
                  "token"=> "",
                  "type"=> "",
                  "subType"=> ""
                ],
                "subType"=> "",
                "issuer"=> "",
                "acquirer"=> ""
              ],
              "instruction"=> [
                "occurrence"=> "",
                "amount"=> "",
                "frequency"=> "",
                "type"=> "",
                "description"=> "",
                "action"=> "",
                "limit"=> "",
                "endDateTime"=> "",
                "identifier"=> "",
                "reference"=> "",
                "startDateTime"=> "",
                "validity"=> ""
              ]
            ],
            "transaction"=> [
              "deviceIdentifier"=> "S",
              "smsSending"=> "",
              "amount"=> "",
              "forced3DSCall "=> "",
              "type"=> "001",
              "description"=> "",
              "currency"=> $mer_array['currency'],
              "isRegistration"=> "",
              "identifier"=> $transactionIdentifier,
              "dateTime"=> "",
              "token"=> $_POST['tpslTransactionID'],
              "securityToken"=> "",
              "subType"=> "006",
              "requestType"=> "TSI",
              "reference"=> "",
              "merchantInitiated"=> "",
              "merchantRefNo"=> ""
            ],
            "consumer"=> [
              "mobileNumber"=> "",
              "emailID"=> "",
              "identifier"=> "",
              "accountNo"=> ""
            ]
           );
      
         $finalJsonReq = json_encode($arr_req);

         function callAPI($method, $url, $finalJsonReq)
         {
            $curl = curl_init();
            switch ($method){
                  case "POST":
                     curl_setopt($curl, CURLOPT_POST, 1);
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);
                     break;
                  case "PUT":
                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                     if ($finalJsonReq)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $finalJsonReq);                              
                     break;
                  default:
                     if ($finalJsonReq)
                        $url = sprintf("%s?%s", $url, http_build_query($finalJsonReq));
            }
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
               'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result)
            {
                  die("Connection Failure !! Try after some time.");
            }
            curl_close($curl);
            return $result;
         }

         $method = 'POST';
         $url = "https://www.paynimo.com/api/paynimoV2.req";
         $res_result = callAPI($method, $url, $finalJsonReq);
         $stopResponseData = json_decode($res_result, true);

         
            
               
         return view('stop_payment_request',compact('stopResponseData'));
         }

         public function submit_request(Request $request)
         {
            $data = array(
               'merchantCode'							=> $_POST['merchantCode'],
                'merchantSchemeCode' 					=> $_POST['merchantSchemeCode'],
                'salt'									=> $_POST['salt'],
                'typeOfPayment' 						=> $_POST['typeOfPayment'],
                'currency' 								=> $_POST['currency'],
                'primaryColor' 							=> $_POST['primaryColor'],
                'secondaryColor'						=> $_POST['secondaryColor'],
                'buttonColor1' 							=> $_POST['buttonColor1'],
                'buttonColor2' 							=> $_POST['buttonColor2'],
                'logoURL'			 					=> $_POST['logoURL'],
                'enableExpressPay' 						=> $_POST['enableExpressPay'],
                'separateCardMode' 						=> $_POST['separateCardMode'],
                'enableNewWindowFlow'		 			=> $_POST['enableNewWindowFlow'],
                'merchantMessage' 						=> $_POST['merchantMessage'],
                'disclaimerMessage' 					=> $_POST['disclaimerMessage'],
                'paymentMode' 							=> $_POST['paymentMode'],
                'paymentModeOrder' 						=> $_POST['paymentModeOrder'],
                'enableInstrumentDeRegistration' 		=> $_POST['enableInstrumentDeRegistration'],
                'transactionType'						=> $_POST['transactionType'],
                'hideSavedInstruments' 					=> $_POST['hideSavedInstruments'],
                'saveInstrument' 						=> $_POST['saveInstrument'],
                'displayTransactionMessageOnPopup' 		=> $_POST['displayTransactionMessageOnPopup'],
                'embedPaymentGatewayOnPage' 			=> $_POST['embedPaymentGatewayOnPage'],
                'enableEmandate' 						=> $_POST['enableEmandate'],
                'hideSIConfirmation'					=> $_POST['hideSIConfirmation'],
                'expandSIDetails'						=> $_POST['expandSIDetails'],
                'enableDebitDay'						=> $_POST['enableDebitDay'],
                'showSIResponseMsg' 					=> $_POST['showSIResponseMsg'],
                'showSIConfirmation'					=> $_POST['showSIConfirmation'],
                'enableTxnForNonSICards' 				=> $_POST['enableTxnForNonSICards'],
                'showAllModesWithSI' 					=> $_POST['showAllModesWithSI'],
                'enableSIDetailsAtMerchantEnd' 			=> $_POST['enableSIDetailsAtMerchantEnd']
            );
         
            $newData = json_encode($data);
            $path = storage_path() . "/json/worldline_AdminData.json";
             
            if(file_exists($path))
            {  
                unlink($path);
                if(file_put_contents( ($path), $newData ) ) 
                { 
                    echo 'Admin Details updated successfully !!';
                }
                else
                { 
                    echo 'There is some error'; 
                }
            } 
            $this->validate($request,[
               'title' => 'required',
               'details' => 'required'
               ]);
       
          $items = Item::create($request->all());
       
          return back()->with('success','Item created successfully!');
           
         }

            public function s2s(){
               $path = storage_path() . "/json/worldline_AdminData.json";
               if(isset($_GET['msg'])){
                   $msg = trim($_GET['msg']);
                   $msg_arr = explode("|", $msg);
                   $count = count($msg_arr);
                   $hash = $msg_arr[$count-1]; //Last hash value in pipe generated response
                   $mer_array = json_decode(file_get_contents($path), true);
                   $updated_array = array_slice($msg_arr,0,$count-1,false);
                   $new_array = array_push($updated_array,$mer_array['salt']);
                   $updated_msg = implode("|", $updated_array);
                   $hashed = hash('sha512',$updated_msg); //Hash value of pipe generated response except last value
                   if($hash == $hashed)
                   {
                       echo $msg_arr[3].'|'.$msg_arr[5].'|1';
                   }
                   else
                   {
                       echo $msg_arr[3].'|'.$msg_arr[5].'|0';
                   }
               }
               else
               {
                   echo "ERROR !!! Invalid Input.";
               }
            }
         
}
