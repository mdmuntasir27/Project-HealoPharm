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
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $f_id = (int)$_POST['f_id'];
        $p_id = (int)$_POST['p_id'];
        $s_date = date("Y-m-d");
        $days = (int)$_POST['days'];

        // Check if f_id and p_id are valid
        $sql_fidCheck = "SELECT * FROM bed WHERE f_id='$f_id'";
        $sql_idCheck = "SELECT * FROM patient WHERE id='$p_id'";
        $result_fidCheck = $conn->query($sql_fidCheck);
        $result_idCheck = $conn->query($sql_idCheck);
        
        if ($result_idCheck->num_rows > 0 && $result_fidCheck->num_rows > 0) {
                $price_ret = "SELECT b_price FROM bed WHERE f_id=$f_id";
                $result_priceRet = $conn->query($price_ret);
                $row_price = $result_priceRet->fetch_assoc();
                $raw_price = $row_price['b_price'];
                $b_price = $days*$raw_price;
                $sql_status = "SELECT status FROM bed WHERE f_id=$f_id";
                $result_status = $conn->query($sql_status);
                $row_status = $result_status->fetch_assoc();
                $status = $row_status['status'];

                // Fetch the cart_id for the patient
                $sql_cartId_ret = "SELECT cart_id FROM billing_cart WHERE p_id=$p_id";
                $result_cartId_ret = $conn->query($sql_cartId_ret);
                $row_cartId = $result_cartId_ret->fetch_assoc();
                $cart_id = $row_cartId['cart_id'];
                
                if ($status=="available") {
                    // Insert into avails table
                    $add_avail = "INSERT INTO avails VALUES ('$p_id', '$f_id', 'Bed', $days, $b_price, '$s_date')";
                    $result_addAvails = $conn->query($add_avail);

                    // Update status into bed table
                    $update_status = "UPDATE bed SET status='booked', days=$days WHERE f_id=$f_id";
                    $result_updateStatus = $conn->query($update_status);

                    // Insert into stores table
                    $add_stores = "INSERT INTO stores VALUES ($cart_id, $f_id)";
                    $result_addStores = $conn->query($add_stores);

                    // Update total_amount in billing_cart
                    $price_inc = "UPDATE billing_cart SET total_amount = total_amount + $b_price WHERE p_id='$p_id'";
                    $result_priceInc = $conn->query($price_inc);

                    // Redirect to lab2.php
                    header("Location: bed2.php");
                    exit();
                } else {
                    header("Location: bed3.php");
                }
            }else {
                header("Location: bed4.php");
                exit();
            }
    }
    $conn->close();
?>
