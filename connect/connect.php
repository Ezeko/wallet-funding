<?php

    //initialize connection details

    $servername = 'localhost';
    $dbname = 'wallet-funding';
    $user = 'root';
    $userpwd = '';

    //connection script
    $connected = mysqli_connect( $servername, $user, $userpwd, $dbname);

    if ($connected) {
        //echo ('connected to ' . $dbname);
    } else {
        die('failed to connect '. mysqli_connect_error());
    }

?>