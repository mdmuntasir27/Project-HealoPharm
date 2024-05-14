<?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dummy_healopharm";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $p_id = $_POST["p_id"];
        $amount_paid=$_POST["amount"];
        $p_id_check="SELECT total_amount FROM billing_cart WHERE p_id=$p_id";
        $result_p_id_check=mysqli_query($conn, $p_id_check);
        $row=$result_p_id_check->fetch_assoc();
        $due_amount=$row["total_amount"];
        if ($result_p_id_check->num_rows >0){
            if ($due_amount-$amount_paid==0){
                $update_amount="UPDATE billing_cart SET total_amount=total_amount-$amount_paid WHERE p_id=$p_id";
                $update_result=mysqli_query($conn, $update_amount);
                header("Location: successful_payment.php");
                exit();
            }else {
                header("Location: unsuccessful_payment.php");
                exit();
            }
        }else {
            header("Location: incorrect_p_id.php");
            exit();
        }
    }
?>