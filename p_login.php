<?php
require_once('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $p_id = (int)$_POST['id'];
    $password = $_POST['p_pass'];

    $sql_query = "select * from patient where id= $p_id and p_pass = '$password'";
    $result = mysqli_query($conn, $sql_query);

    if (mysqli_num_rows($result)==1){
        header("Location: patients login view.html");
        exit();
    }
    else{
        header("Location: p_login_error.html");
        exit();
    }
}
?>