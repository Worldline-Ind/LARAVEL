
<html>
<head>
    <title>Transaction Verification</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Transaction Verification :</h2>

                <form method="POST" id="myform" action="/transaction_verification_request">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <tr class="info">
                            <th width="40%">Field Name</th>
                            <th width="60%">Value</th>
                        </tr>
                        <tr>
                            <td><label>Type of Transaction (eMandate/SI on Cards) <span style="color:red;">*</span></label></td>
                            <td>
                                <select class="form-control" name="type" required >
                                    <option value="002" selected="selected">eMandate</option>
                                    <option value="001" >SI on Cards</option>
                                </select>
                            </td>
                        </tr>        
                        <tr>
                            <td><label>Merchant Transaction ID (From Transaction Scheduling)<span style="color:red;">*</span></label></td>
                            <td><input class="form-control" type="text" name="merchantTransactionID" value="" required/></td>
                        </tr>
                        <tr>
                            <td><label>Date <span style="color:red;">*</span></label></td>
                            <td><input class="form-control" type="date" name="transactionDate" value="" required/></td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <input class="btn btn-info" type="submit" name="submit" value="Submit" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
 
</body>
</html>