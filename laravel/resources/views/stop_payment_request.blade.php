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
      <td><?php echo $stopResponseData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
    </tr>
    <tr>
      <td>Merchant Transaction Reference No.</td>
      <td><?php echo $stopResponseData["merchantTransactionIdentifier"]; ?></td>
    </tr>
    <tr>
      <td>Message</td>
      <td><?php echo $stopResponseData["paymentMethod"]["error"]["desc"]; ?></td>
    </tr>
  </tbody>
</table><br>
<a href="{{route('stop_payment')}}" >Go Back To Stop Payment</a>

