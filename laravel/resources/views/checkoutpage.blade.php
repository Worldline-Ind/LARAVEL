<div id="worldline_embeded_popup"></div>

<script type="text/javascript"  src="https://www.paynimo.com/paynimocheckout/client/lib/jquery.min.js" ></script>
<script type="text/javascript" src="https://www.paynimo.com/Paynimocheckout/server/lib/checkout.js"></script>
<script type="text/javascript">
      
    $(document).ready(function() { 
        var configJson = { 
            'tarCall': false,
            'features': {
                'showPGResponseMsg': true,
                'enableNewWindowFlow' : true,
                'enableAbortResponse': true, 
                'enableExpressPay': {!! ($mer_array['enableExpressPay'] == 1) ? 'true' : 'false' !!},
                'enableInstrumentDeRegistration': {!! ($mer_array['enableInstrumentDeRegistration'] == 1) ? 'true' : 'false' !!},
                'enableMerTxnDetails': true,  
                'siDetailsAtMerchantEnd': {!! ($mer_array['enableSIDetailsAtMerchantEnd'] == 1) ? 'true' : 'false' !!},
                'enableSI': {!! ($mer_array['enableEmandate'] == 1) ? 'true' : 'false' !!},
                'hideSIDetails': {!! ($mer_array['hideSIConfirmation'] == 1) ? 'true' : 'false' !!},
                'enableDebitDay': {!! ($mer_array['enableDebitDay'] == 1) ? 'true' : 'false' !!},
                'expandSIDetails': {!! ($mer_array['expandSIDetails'] == 1) ? 'true' : 'false'  !!},
                'enableTxnForNonSICards':  {!!  ($mer_array['enableTxnForNonSICards'] == 1) ? 'true' : 'false' !!},
                'showSIConfirmation':  {!! ($mer_array['showSIConfirmation'] == 1) ? 'true' : 'false' !!},
                'showSIResponseMsg': {!! ($mer_array['showSIResponseMsg'] == 1) ? 'true' : 'false' !!},
            },
            'consumerData': {
                'deviceId': 'WEBSH2',	//possible values 'WEBSH1' or 'WEBSH2'
                    'token':'{{$payval['hash']}}',
                    'returnUrl': '/checkout',
                    'responseHandler': handleResponse,
                    'paymentMode': '{{  $mer_array['paymentMode'] }}',
                    'checkoutElement': '{{ ($mer_array['embedPaymentGatewayOnPage'] == 1) ? '#worldline_embeded_popup' : '' }}',
                    'merchantLogoUrl': '{{ $mer_array['logoURL'] }}', //provided merchant logo will be displayed
                    'merchantId': '{{$payval['marchantId']}}',//{{$mer_array['merchantCode']}}
                    'currency': '{{$payval['currencycode']}}',
                    'consumerId': '{{$payval['consumerId']}}',
                    'consumerMobileNo': '{{$payval['mobileNumber']}}',
                    'consumerEmailId': '{{$payval['email']}}',
                    'txnId': '{{$payval['txnId']}}',   //Unique merchant transaction ID
                    'items': [{
                        'itemId': '{{$payval['schemecode']}}',
                        'amount': '{{$payval['amount']}}',
                        'comAmt': '0'
                    }],
                    'customStyle': {
                        'PRIMARY_COLOR_CODE': '{{ $mer_array['primaryColor'] }}',   //merchant primary color code
                        'SECONDARY_COLOR_CODE': '{{ $mer_array['secondaryColor'] }}',   //provide merchant's suitable color code
                        'BUTTON_COLOR_CODE_1': '{{ $mer_array['buttonColor1'] }}',   //merchant's button background color code
                        'BUTTON_COLOR_CODE_2': '{{ $mer_array['buttonColor2'] }}'   //provide merchant's suitable color code for button text
                    },
                    'accountNo': '{{$payval['accNo']}}',    //Pass this if accountNo is captured at merchant side for eMandate/eNACH
                    'accountHolderName': '{{$payval['accountName']}}',  //Pass this if accountHolderName is captured at merchant side for ICICI eMandate & eNACH registration this is mandatory field, if not passed from merchant Customer need to enter in Checkout UI.
                    'ifscCode': '{{$payval['ifscCode']}}',       //Pass this if ifscCode is captured at merchant side.
                    'accountType': '{{$payval['accountType']}}',   //Required for eNACH registration this is mandatory field
                    'debitStartDate': '{{$payval['debitStartDate']}}',
                    'debitEndDate': '{{$payval['debitEndDate']}}', 
                    'maxAmount': '{{$payval['maxAmount']}}', 
                    'amountType': '{{$payval['amountType']}}', 
                    'frequency': '{{$payval['frequency']}}',
                    'merchantMsg': '{{$mer_array['merchantMessage']}}',
                    'disclaimerMsg': '{{$mer_array['disclaimerMessage']}}',
                    'saveInstrument': '{{$mer_array['saveInstrument']}}',
                    @if(isset($mer_array['paymentModeOrder']))
                    'paymentModeOrder':  ['<?php echo str_replace(",", "','", $mer_array['paymentModeOrder']) ?>']
                    @endif
            }
           
            };
            console.log(configJson);
            $.pnCheckout(configJson);
            if(configJson.features.enableNewWindowFlow) {
                pnCheckoutShared.openNewWindow();
            }
            function handleResponse(res) {
            let stringResponse = res.stringResponse;
            };
        });
</script>

