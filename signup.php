<?php
require_once('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $first_name=$_POST['p_f_name'];
    $last_name=$_POST['p_l_name'];
    $address=$_POST['address'];
    $password=$_POST['p_pass'];
    $phone=$_POST['p_phone'];
    $dob=$_POST['DoB'];
    $gender=$_POST['gender'];
    $mail=$_POST['p_mail'];

    $sql_query = "insert into patient (p_f_name, p_l_name, address, p_pass, p_phone, DoB, gender, p_mail) values ('$first_name', '$last_name', '$address', '$password', '$phone', '$dob', '$gender', '$mail')";
    $result = mysqli_query($conn, $sql_query);

    if ($result){
        header("Location: signup2.php");
        exit();
    }
    else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>