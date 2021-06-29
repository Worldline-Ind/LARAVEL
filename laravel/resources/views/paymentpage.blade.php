<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <title>Payment</title>
    <?php if($mer_array['enableEmandate'] == 1 && $mer_array['enableSIDetailsAtMerchantEnd'] == 1){}elseif($mer_array['enableEmandate'] == 1 && $mer_array['enableSIDetailsAtMerchantEnd'] != 1){ ?>
        <style type="text/css">
            .hid{
                display: none;
            }        
        </style>
    <?php }else{ ?>
        <style type="text/css">
            .hid{
                display: none;
            }        
        </style>
    <?php } ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Payment Details</h2>
                <form action="/pay" method="post">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <tr class="info">
                            <th width="40%">Field Name</th>
                            <th width="60%">Field Value</th>
                        </tr> 
                        <tr class="hidden">
                            <td><label>Merchant ID</label></td>
                            <td><input type="text" name="marchantId" value="<?php echo $mer_array['merchantCode']; ?>"></td>
                        </tr>
                        <tr class="hidden">
                            <td><label>SALT</label></td>
                            <td><input type="text" name="salt" value="<?php echo $mer_array['salt']; ?>"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Transaction ID</label></td>
                            <td><input type="text" name="txnId" value="<?php echo rand(100000000,1);?>"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Total Amount<span style="color:red;">*</span></label></td>
                            <td><input type="text" name="amount" value="" required></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Currency Code</label></td>
                            <td><input type="text" name="currencycode" value="<?php echo $mer_array['currency']; ?>"></td>
                        </tr>
                        <tr class="hidden">
                            <td><label>Scheme Code</label></td>
                            <td><input type="text" name="schemecode" value="<?php echo $mer_array['merchantSchemeCode']; ?>"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Consumer ID</label></td>
                            <td><input type="text" name="consumerId" value="c<?php echo rand(1000000,2);?>"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Mobile Number</label></td>
                            <td><input type="text" name="mobileNumber" value="1234567890"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Email</label></td>
                            <td><input type="text" name="email" value="demo@demo.com"></td>
                        </tr>
                        <tr class="paydetail">
                            <td><label>Customer Name</label></td>
                            <td><input type="text" name="customerName" value="demo test"></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Account Number</label></td>
                            <td><input type="number" name="accNo" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Account Name</label></td>
                            <td><input type="text" name="accountName" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>IFSC Code</label></td>
                            <td><input type="text" name="ifscCode" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Account Type</label></td>
                            <td>
                                <select class="form-control" name="accountType" >
                                    <option value="" >-- SELECT -- </option>
                                    <option value="Saving" >Saving</option>
                                    <option value="Current" >Current</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="hid">
                            <td><label>Aadhar Number</label></td>
                            <td><input type="text" name="aadharNumber" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Debit Start Date</label></td>
                            <td><input type="date" name="debitStartDate" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Debit End Date</label></td>
                            <td><input type="date" name="debitEndDate" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>maxAmount</label></td>
                            <td><input type="number" id="mymaxAmount" name="maxAmount" value=""/></td>
                        </tr>
                        <?php 
                        if($mer_array['enableEmandate'] == 1){
                        ?>
                            <tr class="hid">
                                <td><label>Amount Type</label></td>
                                <td>
                                    <select class="form-control" name="amountType" >
                                        <option value="M" selected="selected">Variable</option>
                                        <option value="F" >Fixed</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="hid">
                                <td><label>Frequency</label></td>
                                <td>
                                    <select class="form-control" name="frequency" >
                                        <option value="ADHO" selected="selected"> As and when presented </option>
                                        <option value="DAIL" > Daily </option>
                                        <option value="WEEK" > Weekly </option>
                                        <option value="MNTH" > Monthly </option>
                                        <option value="BIMN" > Bi- monthly </option>
                                        <option value="QURT" > Quarterly </option>
                                        <option value="MIAN" > Semi annually </option>
                                        <option value="YEAR" > Yearly </option>
                                    </select>
                                </td>
                            </tr>
                        <?php }else{ ?>
                        <tr class="hid">
                            <td><label>Amount Type</label></td>
                            <td>
                                <select class="form-control" name="amountType" >
                                    <option value="" selected="selected">SELECT OPTION</option>
                                    <option value="M">Variable</option>
                                    <option value="F" >Fixed</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="hid">
                            <td><label>Frequency</label></td>
                            <td>
                                <select class="form-control" name="frequency" >
                                    <option value="" selected="selected">SELECT OPTION</option>
                                    <option value="ADHO" > As and when presented </option>
                                    <option value="DAIL" > Daily </option>
                                    <option value="WEEK" > Weekly </option>
                                    <option value="MNTH" > Monthly </option>
                                    <option value="BIMN" > Bi- monthly </option>
                                    <option value="QURT" > Quarterly </option>
                                    <option value="MIAN" > Semi annually </option>
                                    <option value="YEAR" > Yearly </option>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="hid">
                            <td><label>Card Number</label></td>
                            <td><input type="text" name="cardNumber" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Exp Month</label></td>
                            <td><input type="text" name="expMonth" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Exp Year</label></td>
                            <td><input type="text" name="expYear" value=""/></td>
                        </tr>
                        <tr class="hid">
                            <td><label>Cvv Code</label></td>
                            <td><input type="text" name="cvvCode" value=""/></td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <button type="submit">Make Payment</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>