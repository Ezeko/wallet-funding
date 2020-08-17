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

        include_once('./connect/connect.php');

        //check database
        $sql = "SELECT * FROM `wallet-funding` WHERE username = '$user' ";
    }


