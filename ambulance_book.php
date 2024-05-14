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
        $f_id_check="SELECT * FROM all_facilities WHERE f_id=$f_id";
        $p_id_check="SELECT * FROM patient WHERE id=$p_id";
        $result_p_id_check=mysqli_query($conn, $p_id_check);
        $result_f_id_check=mysqli_query($conn, $f_id_check);
        if ($result_f_id_check->num_rows > 0 && $result_p_id_check->num_rows >0){
            $amb_availability="SELECT a_availability FROM ambulance WHERE f_id=$f_id";
            $result_avail_retrieval=mysqli_query($conn, $amb_availability);
            $row2=$result_avail_retrieval->fetch_assoc();
            $a_availability=$row2["a_availability"];
            if ($a_availability=="available"){
            // Prepare SQL statement to update ambulance availability status
            $update_sql = "UPDATE ambulance SET a_availability = 'unavailable' WHERE f_id =$f_id";
            $update_result= mysqli_query($conn, $update_sql);
            // Execute the update statement
            if ($update_result) {
                $price_sql = "SELECT a_price FROM ambulance where f_id=$f_id";
                $result_price_retrieval = $conn->query($price_sql);
                $row = $result_price_retrieval->fetch_assoc();
                $amb_price = $row["a_price"];
                $s_date = date("Y-m-d");
                $add_avails = "INSERT INTO avails VALUES ($p_id, $f_id, 'Ambulance', 1, $amb_price, '$s_date')";
                $result_add_avails = mysqli_query($conn, $add_avails);
                $cart_sql = "SELECT cart_id FROM billing_cart where p_id=$p_id";
                $result_cart_retrieval = $conn->query($cart_sql);
                $row1 = $result_cart_retrieval->fetch_assoc();
                $cart_id = $row1["cart_id"];
                $add_stores="INSERT INTO stores VALUES ($cart_id, $f_id)";
                $result_add_stores=mysqli_query($conn, $add_stores);
                $inc_price="UPDATE billing_cart SET total_amount=total_amount+$amb_price WHERE cart_id=$cart_id";
                $result_inc_price=mysqli_query($conn, $inc_price);
                // Redirect back to main page with result message
                header("Location: ambulance2.php?result=Ambulance booked successfully. Availability status updated.");
                exit();
                } else{
                    echo "Error: " .mysqli_error($conn);
                }
    } else {
        header("Location: ambulance_unavailable.php");
    } 
}else{
header("Location: ambulance_error.php");
}
    }
?>
