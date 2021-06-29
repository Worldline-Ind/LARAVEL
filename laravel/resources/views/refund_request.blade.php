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
            <td><?php echo $refundData["merchantCode"]; ?></td>
          </tr>
          <tr>
            <td>Merchant Transaction Identifier</td>
            <td><?php echo $refundData["merchantTransactionIdentifier"]; ?></td>
          </tr>
          <tr>
            <td>Token Identifier</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["identifier"]; ?></td>
          </tr>
          <tr>
            <td>Refund Identifier</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["refundIdentifier"]; ?></td>
          </tr>
          <tr>
            <td>Amount</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["amount"]; ?></td>
          </tr>
          <tr>
            <td>Message</td>
            <td><?php echo  $refundData["paymentMethod"]["paymentTransaction"]["errorMessage"]; ?></td>
          </tr>
          <tr>
            <td>Status Code</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["statusCode"]; ?></td>
          </tr>
          <tr>
            <td>Status Message</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["statusMessage"]; ?></td>
          </tr>
          <tr>
            <td>Date & Time</td>
            <td><?php echo $refundData["paymentMethod"]["paymentTransaction"]["dateTime"]; ?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <a href="{{route('refund')}}">Go Back To Refund Page</a>