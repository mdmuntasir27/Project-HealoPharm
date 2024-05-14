<?php
    // Check if form is submitted

    // Database connection parameters
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
        // Retrieve form data
        $f_id = $_POST["f_id"];
        $p_id = $_POST["p_id"];
        $f_id_check = "SELECT * FROM all_facilities WHERE f_id=$f_id";
        $p_id_check = "SELECT * FROM patient WHERE id=$p_id";
        $result_p_id_check = mysqli_query($conn, $p_id_check);
        $result_f_id_check = mysqli_query($conn, $f_id_check);
        
        if ($result_f_id_check->num_rows > 0 && $result_p_id_check->num_rows > 0) {
            $amb_availability = "SELECT a_availability FROM ambulance WHERE f_id=$f_id";
            $result_avail_retrieval = mysqli_query($conn, $amb_availability);
            $row2 = $result_avail_retrieval->fetch_assoc();
            $a_availability = $row2["a_availability"];
            
            if ($a_availability == "unavailable") {
                // Prepare SQL statement to update ambulance availability status
                $update_sql = "UPDATE ambulance SET a_availability = 'available' WHERE f_id =$f_id";
                $update_result = mysqli_query($conn, $update_sql);
                
                if ($update_result) {
                    $del_avails = "DELETE FROM avails WHERE f_id=$f_id AND p_id=$p_id";
                    $result_del_avails = mysqli_query($conn, $del_avails);
                    
                    $cart_sql = "SELECT cart_id FROM billing_cart where p_id=$p_id";
                    $result_cart_retrieval = $conn->query($cart_sql);
                    $row1 = $result_cart_retrieval->fetch_assoc();
                    $cart_id = $row1["cart_id"];
                    
                    $del_stores = "DELETE FROM stores WHERE cart_id=$cart_id AND f_id=$f_id";
                    $result_del_stores = mysqli_query($conn, $del_stores);
                    
                    // Redirect back to main page with result message
                    header("Location: amb_driver_2.php?result=Service provided successfully. Availability status updated.");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                header("Location: ambulance_error.php");
                exit();
            }
        }
    }
?>
