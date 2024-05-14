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
        $reg_id = (int)$_POST['reg_id'];
        $con_date = date("Y-m-d");
        $sqlCapacity = "SELECT capacity FROM doctor WHERE reg_id = '$reg_id'";
        $sql_idCheck = "SELECT * FROM patient WHERE id='$p_id'";
        $resultCapacity = $conn->query($sqlCapacity);
        $result_idCheck = $conn->query($sql_idCheck);
        if ($resultCapacity->num_rows > 0 && $result_idCheck->num_rows >0) {
            $row = $resultCapacity->fetch_assoc();
            $capacity = $row["capacity"];
            $sql_slot_ret = "SELECT slot FROM doctor WHERE reg_id = $reg_id";
            $result_slot_ret = mysqli_query($conn, $sql_slot_ret);
            $row_slot = $result_slot_ret->fetch_assoc();
            $con_time = $row_slot['slot'];
            if ($capacity>0) {
                $sql_add = "INSERT INTO consultations (p_id, d_reg_no, con_time, con_date) VALUES ($p_id, $reg_id, '$con_time', '$con_date')";
                $result = mysqli_query($conn, $sql_add);
                if($result){
                    $sqlUpdate = "UPDATE doctor SET capacity= capacity-1 WHERE reg_id='$reg_id'";
                    if($conn->query($sqlUpdate)===TRUE) {
                        echo "Appointment booked successfully!";
                        header("Location: appointment2.php");
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else{
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Doctor's capacity is full!";
                header("Location: appointment3.php");
            }
        } else {
            echo "Doctor not found!";
            header("Location: appointment_error.php");
        }
    }
$conn->close();
            
?>