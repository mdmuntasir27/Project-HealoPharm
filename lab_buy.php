<?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dummy_healopharm";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else{
         mysqli_select_db($conn, $dbname);
    }
    // Query to fetch data from lab table
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $f_id = (int)$_POST['f_id'];
        $p_id = (int)$_POST['p_id'];
        $s_date = date("Y-m-d");

        // Check if f_id and p_id are valid
        $sql_fidCheck = "SELECT * FROM lab WHERE f_id='$f_id'";
        $sql_idCheck = "SELECT * FROM patient WHERE id='$p_id'";
        $result_fidCheck = $conn->query($sql_fidCheck);
        $result_idCheck = $conn->query($sql_idCheck);
        
        if ($result_idCheck->num_rows > 0 && $result_fidCheck->num_rows > 0) {
                // Fetch the price of the test
                $price_ret = "SELECT t_price FROM lab WHERE f_id=$f_id";
                $result_priceRet = $conn->query($price_ret);
                $row_price = $result_priceRet->fetch_assoc();
                $l_price = $row_price['t_price'];

                // Fetch the cart_id for the patient
                $sql_cartId_ret = "SELECT cart_id FROM billing_cart WHERE p_id=$p_id";
                $result_cartId_ret = $conn->query($sql_cartId_ret);
                $row_cartId = $result_cartId_ret->fetch_assoc();
                $cart_id = $row_cartId['cart_id'];

                // Insert into avails table
                $add_avail = "INSERT INTO avails VALUES ('$p_id', '$f_id', 'Lab', 1, $l_price, '$s_date')";
                $result_addAvails = $conn->query($add_avail);

                // Insert into stores table
                $add_stores = "INSERT INTO stores VALUES ('$cart_id', '$f_id')";
                $result_addStores = $conn->query($add_stores);

                // Update total_amount in billing_cart
                $price_inc = "UPDATE billing_cart SET total_amount = total_amount + $l_price WHERE p_id='$p_id'";
                $result_priceInc = $conn->query($price_inc);

                // Redirect to lab2.php
                header("Location: lab2.php");
                exit();
            } else {
                // Redirect to lab3.php if l_no or t_type is invalid
                header("Location: lab3.php");
                exit();
            }
        }
    $conn->close();
?>
