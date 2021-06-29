@if (is_array($success_statusCode) )
@foreach($success_statusCode as $reconciliationData)
<table class="table table-bordered table-hover" border = "1" cellpadding="2" cellspacing="0" style="width: 30%;text-align: center;">
    <thead>
      <tr class="info">
        <th>Field Name</th>
        <th>Value</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Merchant Code</td>
        <td><?php echo $reconciliationData["merchantCode"]; ?></td>
      </tr>
      <tr>
        <td>Merchant Transaction Identifier</td>
        <td><?php echo $reconciliationData["merchantTransactionIdentifier"]; ?></td>
      </tr>
      <tr>
        <td>Token Identifier</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
      </tr>
      <tr>
        <td>Amount</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["amount"]; ?></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["errorMessage"]; ?></td>
      </tr>
      <tr>
        <td>Status Code</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
      </tr>
      <tr>
        <td>Status Message</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["statusMessage"]; ?></td>
      </tr>
      <tr>
        <td>Date & Time</td>
        <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
      </tr>
    </tbody>
  </table>
  <br><br>
@endforeach 
@endif

@if (is_array($failure_statusCode))
@foreach($failure_statusCode as $reconciliationData)
<table class="table table-bordered table-hover" border = "1" cellpadding="2" cellspacing="0" style="width: 30%;text-align: center;">
  <thead>
    <tr class="info">
      <th>Field Name</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Merchant Code</td>
      <td><?php echo $reconciliationData["merchantCode"]; ?></td>
    </tr>
    <tr>
      <td>Merchant Transaction Identifier</td>
      <td><?php echo $reconciliationData["merchantTransactionIdentifier"]; ?></td>
    </tr>
    <tr>
      <td>Token Identifier</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
    </tr>
    <tr>
      <td>Amount</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["amount"]; ?></td>
    </tr>
    <tr>
      <td>Message</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["errorMessage"]; ?></td>
    </tr>
    <tr>
      <td>Status Code</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
    </tr>
    <tr>
      <td>Status Message</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["statusMessage"]; ?></td>
    <tr>
      <td>Date & Time</td>
      <td><?php echo $reconciliationData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
    </tr>
  </tbody>
</table>
<br><br>
@endforeach
@endif
<a href="{{route('reconciliation')}}">Go Back To Reconciliation Page</a>
