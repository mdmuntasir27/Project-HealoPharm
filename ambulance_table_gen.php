<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance List</title>
    <link rel='stylesheet' href='appointment_style.css'>
</head>
<body>
    <?php
    //connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dummy_healopharm";
    
    //creating connection
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //check connection 
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $p_id = (int)$_POST['p_id'];

        $check_pid = "SELECT * FROM patient where id=$p_id";
        $run_check_pid = $conn->query($check_pid);
        if ($run_check_pid->num_rows>0){
        $ambulance_query = "SELECT av.f_id, a.amb_no, a.a_time, a.a_price from avails av inner join ambulance a on a.f_id=av.f_id inner join patient p on p.id=av.p_id where p.id=$p_id";
        $run_ambulance_query = $conn->query($ambulance_query);
        if ($run_ambulance_query->num_rows>0){
            echo "<table border='1'>";
            echo "<tr><th>f_id</th><th>Ambulance No.</th><th>Time</th><th>Total Price</th></tr>";
            while($ret_ambulance_table=$run_ambulance_query->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$ret_ambulance_table["f_id"]."</td>";
                echo "<td>".$ret_ambulance_table["amb_no"]."</td>";
                echo "<td>".$ret_ambulance_table["a_time"]."</td>";
                echo "<td>".$ret_ambulance_table["a_price"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "0 results";
        }
    } else{
        // If patient ID doesn't exist, redirect to another page
        header("Location: input_id_ambulance_error.html");
        exit(); // Make sure to exit after redirecting
    }

}

    ?>
    
    <div class="goto-div"><a href="patients login view.html"><button class="back-to-homepage">Back to dashboard</button></a></div>
</body>
</html>