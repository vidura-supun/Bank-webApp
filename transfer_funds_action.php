<?php
    include "validate_customer.php";
    include "header.php";
    include "customer_navbar.php";
    include "customer_sidebar.php";
    include "session_timeout.php";

    $id = $_SESSION['loggedIn_cust_id'];
    $amt = mysqli_real_escape_string($conn, $_POST["amt"]);
    $acc = mysqli_real_escape_string($conn, $_POST["acc_num"]);
    $pass = mysqli_real_escape_string($conn, hash('sha256',$_POST["pass"]));
    $branch = mysqli_real_escape_string($conn, $_POST["branch"]);
    $state = mysqli_real_escape_string($conn, $_POST["purpose"]);

    /*  Set appropriate error number if errors are encountered.
        Key (for err_no) :
        -1 = Connection Error.
         0 = Successful Transaction.
         1 = Insufficient Funds.
         2 = Wrong PIN entered. */
    $err_no = -1;

    $sql_pin = "SELECT * FROM customer WHERE cust_id=$id";
    $receiver = "SELECT * FROM customer WHERE account_no=$acc";
    $result_pin = $conn->query($sql_pin);
    $send_data = $result_pin->fetch_assoc();
    $re_reciever = $conn->query($receiver);
    $rec_data =  $re_reciever->fetch_assoc();

    #adjust the balance of receiver
    $sql0 = "SELECT balance FROM passbook".$rec_data['cust_id']." ORDER BY trans_id DESC LIMIT 1";
    $result = $conn->query($sql0);
    $row = $result->fetch_assoc();
    $balance_rec = $row["balance"];

    #adjust the balance of the sender

    $sql1 = "SELECT balance FROM passbook".$id." ORDER BY trans_id DESC LIMIT 1";
    $result1 = $conn->query($sql1);
    $row = $result1->fetch_assoc();
    $balance_sen = $row["balance"];

    echo($balance_rec.' '.$balance_sen);



    if (($result_pin->num_rows) > 0) {
        // senders account
        $final_balance = $balance_sen-$amt;
        if($final_balance >= 0){

            $sql1 = "INSERT INTO passbook".$rec_data["cust_id"]." VALUES(NULL, NOW(),'$state','$amt','0','$final_balance')";
        
        }

        else{
            $err_no = 1;
        }
            
        if (($conn->query($sql1) === TRUE)) {
            $err_no = 0;
        }
        

        // receivers account

        
        $final_balance2 = $balance_rec + $amt;
        $sql2 = "INSERT INTO passbook".$id." VALUES(NULL, NOW(), '$state', '0', '$amt', '$final_balance2')";
        
        if (($conn->query($sql2) === TRUE)) {
            $err_no = 0;
        }

    }
    else {
        $err_no = 2;
    }
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
            if ($err_no == -1) { ?>
                <p id="info"><?php echo "Connection Error ! Please try again later.\n"; ?></p>
            <?php } ?>

            <?php
            if ($err_no == 0) { ?>
                <p id="info"><?php echo "Transaction Successful !\n"; ?></p>
            <?php } ?>

            <?php
            if ($err_no == 1) { ?>
                <p id="info"><?php echo "Insufficient Funds !\n"; ?></p>
            <?php } ?>

            <?php
            if ($err_no == 2) { ?>
                <p id="info"><?php echo "Wrong PIN Entered !\n"; ?></p>
            <?php } ?>
        </div>

        <div class="flex-item">
            <a href="transfer_funds.php" class="button">Go Back</a>
        </div>
    </div>

</body>
</html>
