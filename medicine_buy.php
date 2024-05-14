<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dummy_healopharm";
    
    //creating connection
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection 
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    } else{
        mysqli_select_db($conn, $dbname);
    }
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $p_id = (int)$_POST['p_id'];
        $f_id = (int)$_POST['f_id'];
        $s_quantity = (int)$_POST['s_quantity'];
        $ordering_date = date("Y-m-d");
        $sqlQuantity = "SELECT m_quantity FROM medicine WHERE f_id = '$f_id'";
        $sql_fidCheck = "SELECT * FROM medicine WHERE f_id='$f_id'";
        $sql_idCheck = "SELECT * FROM patient WHERE id='$p_id'";
        $resultQuantity = $conn->query($sqlQuantity);
        $result_idCheck = $conn->query($sql_idCheck);
        $result_fidCheck = $conn->query($sql_fidCheck);
        if ($result_idCheck->num_rows >0 && $result_fidCheck->num_rows >0) {
            $row = $resultQuantity->fetch_assoc();
            $curr_quantity = $row["m_quantity"];
            if ($curr_quantity-$s_quantity>=0) {
                $price_ret = "SELECT m_price FROM medicine WHERE f_id=$f_id";
                $result_priceRet = $conn->query($price_ret);
                $row_price = $result_priceRet->fetch_assoc();
                $m_price = $row_price['m_price'];
                $s_price = $s_quantity*$m_price;
                $sql_cartId_ret = "SELECT cart_id FROM billing_cart WHERE p_id=$p_id";
                $result_cartId_ret = $conn->query($sql_cartId_ret);
                $row_cartId = $result_cartId_ret->fetch_assoc();
                $cart_id = $row_cartId['cart_id'];
                $add_avail = "INSERT INTO avails VALUES ($p_id, $f_id, 'Medicine', $s_quantity, $s_price, '$ordering_date')";
                $result_addAvails = $conn->query($add_avail);
                $add_stores = "INSERT INTO stores VALUES ($cart_id, $f_id)";
                $result_addStores = $conn->query($add_stores);
                $update_capacity = "UPDATE medicine SET m_quantity = m_quantity-$s_quantity WHERE f_id=$f_id";
                $result_updateQuantity = $conn->query($update_capacity);
                $price_inc = "UPDATE billing_cart SET total_amount=total_amount+$s_price WHERE p_id=$p_id";
                $result_priceInc = $conn->query($price_inc);
                header("Location: medicine2.php");

        } else {
            header("Location: medicine3.php");
            }
        } else {
            header("Location: medicine4.php");
        }
    }
$conn->close();
            
?>