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
            if ($amount > $oldAmount ) {
                echo "<script> alert('Insufficient Fund!!!'); window.location.replace('debit_user.php'); </script>";
                exit;
            }
            $newAmount = $oldAmount - $amount;
            
            //update database

            $sql = "UPDATE `users` SET `amount` = $newAmount WHERE `username` = '$user' ";

            $query = mysqli_query($connected, $sql) or die(mysqli_error($connected));
            
            if ( $query ) {
                //add detail to wallet history
                $insertion = "INSERT INTO `wallet_history` (username, amount, description, balance)
                VALUES ('$user', $amount, '₦$amount debitted by ADMIN', $newAmount)";
                            
                $queryIns = mysqli_query($connected, $insertion) or die(mysqli_error($connected));
                echo "<script> alert('₦$amount has been removed to $user\'s wallet '); window.location.replace('debit_user.php');</script>";
            } else {
                echo "<script> alert('$user wallet cannot be debitted at the moment!!!'); window.location.replace('debit_user.php'); </script>";
            }

            

        } else {
            echo "<script> alert('$user is not registered'); window.location.replace('debit_user.php'); </script>";
        }
    }
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="css/credit.css">
<title> Debit User </title>


<div class="container">
	<div class="row">
        <h2>Debit User!</h2>
        <div class="col-md-3">
            <a href="credit_user.php"> Credit Users Here </a>
        </div>
        <div class="col-md-6">
            <a href="wallet_history.php"> Check Wallet history Here </a>
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
        <input type="submit" value="Credit" class="btn-info form-control" >
    </div>
    </form>
</div>
    