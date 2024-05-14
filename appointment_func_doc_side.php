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
        $sql_regCheck = "SELECT * FROM doctor WHERE reg_id = $reg_id";
        $sql_idCheck = "SELECT * FROM patient WHERE id=$p_id";
        $result_regCheck = $conn->query($sql_regCheck);
        $result_idCheck = $conn->query($sql_idCheck);
        if ($result_regCheck->num_rows > 0 && $result_idCheck->num_rows >0) {
            $sql_delete = "DELETE FROM consultations WHERE p_id=$p_id AND d_reg_no=$reg_id AND con_date='$con_date'";
            $result = mysqli_query($conn, $sql_delete);
            if($result) {
                $sql_capacityUpdate = "UPDATE doctor SET capacity=capacity+1 WHERE reg_id=$reg_id";
                if($conn->query($sql_capacityUpdate)===TRUE) {
                    header("Location: appointment_dReg_inputpageDone.html");
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            } else {
                echo "Doctor or Patient not found";
                header("Location: appointment_dReg_inputpageFailed.html");
            }
        } else {
            echo "Doctor not found!";
        }
$conn->close();
            
?>