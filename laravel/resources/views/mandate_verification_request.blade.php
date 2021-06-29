<table class="table" border = "1" align="center" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
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
      <td><?php echo $verifyData["paymentMethod"]["token"]; ?></td>
    </tr>
    <tr>
      <td>Tpsl Transaction ID</td>
      <td><?php echo $verifyData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
    </tr>
    <tr>
      <td>Status Message</td>
      <td><?php echo $verifyData["paymentMethod"]["paymentTransaction"]["statusMessage"]; ?></td>
    </tr>
  </tbody>
  </table><br>
      <a href="{{route('mandate_verification')}}">Go Back To Mandate Verification</a>
