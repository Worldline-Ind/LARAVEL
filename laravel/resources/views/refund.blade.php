<html>
<head>
    <title>Refund Process</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>Refund Process :</h2>

                <form method="POST" id="myform" action="/refund_request">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <tr class="info">
                            <th width="40%">Field Name</th>
                            <th width="60%">Value</th>
                        </tr>         
                        <tr>
                            <td><label>Transaction Identifier (Token) <span style="color:red;">*</span></label></td>
                            <td><input class="form-control" type="text" name="transactionIdentifier" value="" required/></td>
                        </tr>
                        <tr>
                            <td><label>Amount <span style="color:red;">*</span></label></td>
                            <td><input class="form-control" type="number" name="amount" value="" required/></td>
                        </tr>
                        <tr>
                            <td><label>Transaction Date <span style="color:red;">*</span></label></td>
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
<!-- <?php if(isset($encrypt)){ ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <?php echo "<pre>";print_r($encrypt);die(); ?>
                </table>
            </div>
        </div>
    </div>
<?php } ?> -->  
</body>
</html>