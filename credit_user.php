<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //check method of sending request
        function check_input ( $input ) {
            trim($input); //remove extra spaces
            stripslashes( $input); //strip slashes
            htmlspecialchars($input); // encode special characters

            return $input;
        }
        $data = $_POST['amount'];
        $amount = check_input($data);
        $user = check_input($_POST['username']);

        include_once('./connect/connect.php'); // include connection script

        //check database
        $sql = "SELECT * FROM `users` WHERE username = '$user' ";
        $query = mysqli_query( $connected, $sql) or die(mysqli_error($connected));

        if ( $query ) {
            //user is a registered user 
            //continue processing
            $oldAmount = mysqli_fetch_array($query)['amount'];

            $newAmount = $amount + $oldAmount;

            //update database

            $sql = "UPDATE `users` set amount = '$newAmount' WHERE username = '$user' ";

            $query = mysqli_query($connected, $sql) or die(mysqli_error( $connected ));

            if ( $query ) {
                echo "<script> alert('$amount has been added to $user\'s wallet '); <window class='credit_user.php'></window> </script>";
            } else {
                echo "<script> alert('$user wallet cannot be fund at the moment!!!'); <window class='credit_user.php'></window> </script>";
            }

            

        } else {
            echo "<script> alert('$user is not registered'); <window class='credit_user.php'></window> </script>";
        }
    }
?>

