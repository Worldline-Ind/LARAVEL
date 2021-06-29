<table class="table table-bordered table-hover" border = "1" cellpadding="2" cellspacing="0" style="width: 50%;text-align: center;">
  <thead>
    <tr class="info">
      <th>Field Name</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Status Code</td>
      <td><?php echo $schedulingData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
    </tr>
    <tr>
      <td>Merchant transaction reference no </td>
      <td><?php echo $schedulingData["merchantTransactionIdentifier"]; ?></td>
    </tr>
    <tr>
      <td>Tpsl Transaction Id </td>
      <td><?php echo $schedulingData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
    </tr>
    <tr>
      <td>Message</td>
      <td><?php echo $schedulingData["paymentMethod"]["paymentTransaction"]["errorMessage"]; ?></td>
    </tr>
    <tr>
      <td>Amount</td>
      <td><?php echo $schedulingData["paymentMethod"]["paymentTransaction"]["amount"]; ?></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><?php echo $schedulingData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
    </tr>
  </tbody>
</table><br>
<a href="{{route('transaction_scheduling')}}">Go Back To Transaction Scheduling</a>
