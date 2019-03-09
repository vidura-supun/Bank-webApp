<?php
    include "connect.php";
    
    /* Avoid multiple sessions warning
    Check if session is set before starting a new one. */
    if(!isset($_SESSION)) {
        session_start();
    }

    $pass = hash('sha256',$_POST["cust_psw"]);
    $uname = mysqli_real_escape_string($conn, trim(stripslashes($_POST["cust_uname"])));
    $pwd = mysqli_real_escape_string($conn, $pass);

    $sql0 =  "SELECT * FROM customer WHERE uname='".$uname."' AND pwd='".$pwd."'";
    $result = $conn->query($sql0);
    $row = $result->fetch_assoc();

    if ($pwd . $row['salt'] == $row['pwd'] . $row['salt']) {
        $_SESSION['loggedIn_cust_id'] = $row["cust_id"];
        $_SESSION['isCustValid'] = true;
        $_SESSION['LAST_ACTIVITY'] = time();
        header("location:customer_home.php");
    }
    else {
        print($row);
        //session_destroy();
        //die(header("location:home.php?loginFailed=true"));
    }
?>
