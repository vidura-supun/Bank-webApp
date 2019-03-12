<?php
    include "validate_customer.php";
    include "header.php";
    include "customer_navbar.php";
    include "customer_sidebar.php";
    include "session_timeout.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="customer_add_style.css">
</head>

<body>
    <form class="add_customer_form" action="transfer_funds_action.php" method="post">
        <div class="flex-container-form_header">
            <h1 id="form_header">Transfer Funds</h1>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Receivers account number :</label><br>
                <input name="acc_num" size="24" type="text" required />
            </div>
        </div>

        <div class="flex-container">
        <div class=container>
            <label>Bank Branch :</label>
        </div>
        <div  class=container>
            <select name="branch">
            <option value="colombo">colombo</option>
            <option value="Kalutara" >Kalutara</option>
            <option value="Malabe" >Malabe</option>
            <option value="Kandy" >Kandy</option>
            <option value="Galle" >Galle</option>
            </select>
        </div>
    </div>

        <div class="flex-container">
            <div class=container>
                <label>Purpose of transfering:</label><br>
                <input name="purpose" size="200" type="text" required />
            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>Enter Amount (in SLR) :</label><br>
                <input name="amt" size="24" type="text" required />
            </div>
        </div>




        <div class="flex-container">
            <div  class=container>
                <label>Password :</b></label><br>
                <input name="pass" size="20" type="password" required />
            </div>
        </div>

        <div class="flex-container">
            <div class="container">
                <button type="submit">Submit</button>
            </div>

            <div class="container">
                <button type="reset" class="reset" onclick="return confirmReset();">Reset</button>
            </div>
        </div>

    </form>

    <script>
    function confirmReset() {
        return confirm('Do you really want to reset?')
    }
    </script>

</body>
</html>
