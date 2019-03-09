<?php
    /* Avoid multiple sessions warning
    Check if session is set before starting a new one. */
    if(!isset($_SESSION)) {
        session_start();
    }

    include "validate_admin.php";
    include "connect.php";
    include "header.php";
    include "user_navbar.php";
    include "admin_sidebar.php";
    include "session_timeout.php";

    if (isset($_GET['cust_id'])) {
        $_SESSION['cust_id'] = $_GET['cust_id'];
    }

    $pass = hash('sha256',$_POST["cus_pwd"]);
    $fname = mysqli_real_escape_string($conn, trim(stripslashes($_POST["fname"])));
    $lname = mysqli_real_escape_string($conn, trim(stripslashes($_POST["lname"])));
    $dob = mysqli_real_escape_string($conn, trim(stripslashes($_POST["dob"])));
    $aadhar = mysqli_real_escape_string($conn, trim(stripslashes($_POST["aadhar"])));
    $email = mysqli_real_escape_string($conn, trim(stripslashes($_POST["email"])));
    $phno = mysqli_real_escape_string($conn, trim(stripslashes($_POST["phno"])));
    $address = mysqli_real_escape_string($conn, trim(stripslashes($_POST["address"])));
    $branch = mysqli_real_escape_string($conn, trim(stripslashes($_POST["branch"])));
    $acno = mysqli_real_escape_string($conn, trim(stripslashes($_POST["acno"])));
    $pin = mysqli_real_escape_string($conn, trim(stripslashes($_POST["pin"])));
    $cus_uname = mysqli_real_escape_string($conn, trim(stripslashes($_POST["cus_uname"])));
    $cus_pwd = mysqli_real_escape_string($conn, $pass);

    $sql0 = "UPDATE customer SET first_name = '$fname',
                                 last_name = '$lname',
                                 dob = '$dob',
                                 aadhar_no = '$aadhar',
                                 email = '$email',
                                 phone_no = '$phno',
                                 address = '$address',
                                 branch = '$branch',
                                 account_no = '$acno',
                                 pin = '$pin',
                                 uname = '$cus_uname',
                                 pwd = '$cus_pwd'
                            WHERE cust_id=".$_SESSION['cust_id'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="action_style.css">
</head>

<body>
    <div class="flex-container">
        <div class="flex-item">
            <?php
                if (($conn->query($sql0) === TRUE)) { ?>
                    <p id="info"><?php echo "Values Updated Successfully !"; ?></p>
                <?php
                }
                else { ?>
                    <p id="info"><?php echo "Error: " . $sql0 . "<br>" . $conn->error . "<br>"; ?></p>
                <?php
                }
            ?>
        </div>
        <?php $conn->close(); ?>

        <div class="flex-item">
            <a href="/manage_customers.php" class="button">Go Back</a>
        </div>

    </div>

</body>
</html>
