@if (isset($offlineVerifyData)) 
  
   <table class="table table-bordered table-hover" border = "1" align="center" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
    <thead>
      <tr class="info">
        <th>Field Name</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Merchant Code</td>
        <td><?php echo $offlineVerifyData["merchantCode"]; ?></td>
      </tr>
      <tr>
        <td>Merchant Transaction Identifier</td>
        <td><?php echo $offlineVerifyData["merchantTransactionIdentifier"]; ?></td>
      </tr>
      <tr>
        <td>Token Identifier</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["amount"]; ?></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["errorMessage"]; ?></td>
      </tr>
      <tr>
        <td>Status Code</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
      </tr>
      <tr>
        <td>Status Message</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["statusMessage"]; ?></td>
      </tr>
      <tr>
        <td>Date & Time</td>
        <td><?php echo $offlineVerifyData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <a href= "{{route('offline_verification')}}">Go Back To Offline Verification Page</a>';


@else 
   {{ print("No response found") }} 
    @endif