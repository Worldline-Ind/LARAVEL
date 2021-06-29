<table class="table" border = "1" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
        <thead>
          <tr class="info">
            <th>Field Name</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Status Code</td>
            <td><?php echo $verifyData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
          </tr>
          <tr>
            <td>Merchant Transaction Reference No.</td>
            <td><?php echo $verifyData["merchantTransactionIdentifier"]; ?></td>
          </tr>
          <tr>
            <td>Tpsl Transaction ID</td>
            <td><?php echo $verifyData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
          </tr>
          <tr>
            <td>Message</td>
            <td><?php echo $verifyData["paymentMethod"]["error"]["desc"]; ?></td>
          </tr>
         @if($verifyData["paymentMethod"]["paymentTransaction"]["statusMessage"] == "S")
        <tr>
            <td>Status</td>
            <td>Success</td>
          </tr>
    
        @elseif ($verifyData["paymentMethod"]["paymentTransaction"]["statusMessage"] == "I") 
       <tr>
            <td>Status</td>
            <td>Initiated</td>
          </tr>
  
        @elseif ($verifyData["paymentMethod"]["paymentTransaction"]["statusMessage"] == "F") 
       <tr>
            <td>Status</td>
            <td>Failure</td>
          </tr>
       @elseif ($verifyData["paymentMethod"]["paymentTransaction"]["statusMessage"] == "A") {
       <tr>
            <td>Status</td>
            <td>Aborted</td>
          </tr>
   @endif
          
   <tr>
            <td>Date</td>
            <td><?php echo $verifyData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <a href="{{route('transaction_verification')}}">Go Back To Transaction Verification</a>
