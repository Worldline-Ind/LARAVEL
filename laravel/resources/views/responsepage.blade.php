@if (isset($response)) 
   {{ print_r($response) }} 
@else 
   {{ print("No response found") }} 
    @endif

     @if(isset($res_msg)) 
           
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2> Online Transaction Result : </h2>
                    <table class="table" border = "1" align="center" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
                    <thead>
                      <tr class="info">
                        <th>Field Name</th>
                        <th>Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Txn Status</td>
                        <td><?php echo $res_msg[0]; ?></td>
                      </tr>
                      <tr>
                        <td>Txn Msg</td>
                        <td><?php echo $res_msg[1]; ?></td>
                      </tr>
                      <tr>
                        <td>Txn Err Msg</td>
                        <td><?php echo $res_msg[2]; ?></td>
                      </tr>
                      <tr>
                        <td>Clnt Txn Ref</td>
                        <td><?php echo $res_msg[3]; ?></td>
                      </tr>
                      <tr>
                        <td>Tpsl Bank Cd</td>
                        <td><?php echo $res_msg[4]; ?></td>
                      </tr>
                      <tr>
                        <td>Tpsl Txn Id</td>
                        <td><?php echo $res_msg[5]; ?></td>
                      </tr>
                      <tr>
                        <td>Txn Amt</td>
                        <td><?php echo $res_msg[6]; ?></td>
                      </tr>
                      <tr>
                        <td>Clnt Rqst Meta</td>
                        <td><?php echo $res_msg[7]; ?></td>
                      </tr>
                      <tr>
                        <td>Tpsl Txn Time</td>
                        <td><?php echo $res_msg[8]; ?></td>
                      </tr>
                      <tr>
                        <td>Bal Amt</td>
                        <td><?php echo $res_msg[9]; ?></td>
                      </tr>
                      <tr>
                        <td>Card Id</td>
                        <td><?php echo $res_msg[10]; ?></td>
                      </tr>
                      <tr>
                        <td>Alias Name</td>
                        <td><?php echo $res_msg[11]; ?></td>
                      </tr>
                      <tr>
                        <td>Bank Transaction ID</td>
                        <td><?php echo $res_msg[12]; ?></td>
                      </tr>
                      <tr>
                        <td>Mandate Reg No</td>
                        <td><?php echo $res_msg[13]; ?></td>
                      </tr>
                      <tr>
                        <td>Token</td>
                        <td><?php echo $res_msg[14]; ?></td>
                      </tr>
                      <tr>
                        <td>Hash</td>
                        <td><?php echo $res_msg[15]; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>        
        </div><br><br>
        @endif

        <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h2> Dual-Verification : </h2>
                  <table class="table" border = "1" align="center" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
                  <thead>
                    <tr class="info">
                      <th>Field Name</th>
                      <th>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Merchant Code</td>
                      <td><?php echo $dualVerifyData['merchantCode']; ?></td>
                    </tr>
                    <tr>
                      <td>Merchant Transaction Identifier</td>
                      <td><?php echo $dualVerifyData['merchantTransactionIdentifier']; ?></td>
                    </tr>
                    <tr>
                      <td>worldline Identifier(Token)</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['identifier']; ?></td>
                    </tr>
                    <tr>
                      <td>Amount</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['amount']; ?></td>
                    </tr>
                    <tr>
                      <td>Message</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['errorMessage']; ?></td>
                    </tr>
                    <tr>
                      <td>Status Code</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['statusCode']; ?></td>
                    </tr>
                    <tr>
                      <td>Status Message</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['statusMessage']; ?></td>
                    </tr>
                    <tr>
                      <td>Date & Time</td>
                      <td><?php echo $dualVerifyData['paymentMethod']['paymentTransaction']['dateTime']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>        
      </div><br>

        <table class="table" border = "1" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
            <tr>
              <td><a href="{{route('start')}}">BACK TO PAYMENT PAGE</a><br></td>
              <td><a href="{{route('offline_verification')}}">GO TO OFFLINE-VERIFICATION</a></td>
              <td><a href="{{route('reconciliation')}}">GO TO RECONCILIATION</a></td>
              <td><a href="{{route('refund')}}">GO TO REFUND</a></td>
              <td><a href="{{route('mandate_verification')}}">GO TO MANDATE VERIFICATION</a></td>
              <td><a href="{{route('transaction_scheduling')}}">GO TO TRANSACTION SCHEDULING</a></td>
              <td><a href="{{route('transaction_verification')}}">GO TO TRANSACTION VERIFICATION</a></td>
              <td><a href="{{route('mandate_deactivation')}}">GO TO MANDATE DEACTIVATION</a></td>
              <td><a href="{{route('stop_payment')}}">GO TO STOP PAYMENT</a></td>
            </tr>
          </table><br>