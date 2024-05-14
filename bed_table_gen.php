<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed List</title>
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
        $bed_query = "SELECT b.f_id, b.bed_no, b.category, b.days from bed b inner join avails  a  on a.f_id = b.f_id inner join patient p on p.id = a.p_id where a.p_id =$p_id";
        $run_bed_query = $conn->query($bed_query);
        if ($run_bed_query->num_rows>0){
            echo "<table border='1'>";
            echo "<tr><th>f_id</th><th>Bed No.</th><th>Bed Category</th><th>Total Booking Days</th></tr>";
            while($ret_bed_table=$run_bed_query->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$ret_bed_table["f_id"]."</td>";
                echo "<td>".$ret_bed_table["bed_no"]."</td>";
                echo "<td>".$ret_bed_table["category"]."</td>";
                echo "<td>".$ret_bed_table["days"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "0 results";
        }
    } else{
        // If patient ID doesn't exist, redirect to another page
        header("Location: input_id_bed_error.html");
        exit(); // Make sure to exit after redirecting
    }

}

    ?>
    
    <div class="goto-div"><a href="patients login view.html"><button class="back-to-homepage">Back to dashboard</button></a></div>
</body>
</html>