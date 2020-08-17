<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //check method of sending request
        include_once('./connect/connect.php'); // include connection script
        
        function check_input ( $input ) {
            trim($input); //remove extra spaces
            stripslashes( $input); //strip slashes
            htmlspecialchars($input); // encode special characters

            return $input;
        }
        $data = $_POST['amount'];
        $amount = check_input($data);
        $user = check_input($_POST['username']);
        


        //check database
        $sql = "SELECT * FROM `users` WHERE username = '$user' ";
        $query = mysqli_query( $connected, $sql) or die(mysqli_error($connected));
        $queryArray = mysqli_fetch_array($query);

        if ( count($queryArray) > 0 ) {
            //user is a registered user 
            //continue processing
            $oldAmount = $queryArray['amount'];

            $newAmount = $oldAmount + $amount;
            
            //update database

            $sql = "UPDATE `users` SET `amount` = $newAmount WHERE `username` = '$user' ";

            $query = mysqli_query($connected, $sql) or die(mysqli_error($connected));
            
            if ( $query ) {
                
                echo "<script> alert('₦$amount has been added to $user\'s wallet '); window.location.replace('credit_user.php');</script>";
            } else {
                echo "<script> alert('$user wallet cannot be funded at the moment!!!'); window.location.replace('credit_user.php'); </script>";
            }

            

        } else {
            echo "<script> alert('$user is not registered'); window.location.replace('credit_user.php'); </script>";
        }
    }
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="css/credit.css">


<div class="container">
	<div class="row">
        <h2>Credit User!</h2>
        <div class="col-md-6">
        <a href="debit_user.php"> Debit Users Here </a>
    </div>
</div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" >
    <div class="row form-group">
        <div> 
            <label for="amount"> AMOUNT</label>
        </div>
        <div class="input-group">
            <span class="input-group-addon primary"><span class="glyphicon glyphicon-star"></span></span>
            <input type="number" class="form-control" name="amount"
            placeholder="amount to be credited" required>
        </div>
    </div>
    <div class="row form-group">
        <div>
            <label for="username"> USERNAME</label>
        </div>
        <div class="input-group">
            <span class="input-group-addon info"><span class="glyphicon glyphicon-info-sign"></span></span>
            <input type="text" class="form-control" name="username"
            placeholder="username" required>
        </div>
    </div>
    <div>
        <input type="submit" value="Credit" class="btn-success form-control" >
    </div>
    </form>
</div>
    