<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab List</title>
    <link rel='stylesheet' href='lab_table_gen_style.css'>
</head>
<body>
<?php
// Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dummy_healopharm";

// Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection 
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_id = (int)$_POST['p_id'];
    $check_pid = "SELECT * FROM patient WHERE id=$p_id";
    $run_check_pid = $conn->query($check_pid);
    
    if ($run_check_pid->num_rows > 0) {
        $lab_query = "select a.f_id, l.lab_no, l.test_type, l.t_price, a.ordering_date from lab l inner join avails a on l.f_id=a.f_id inner join patient p on p.id=a.p_id where p.id=$p_id;";
        $run_lab_query = $conn->query($lab_query);
        
        if ($run_lab_query !== false && $run_lab_query->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>f_id</th><th>Lab No</th><th>Test Type</th><th>Total Price</th><th>Ordering Date</th></tr>";
            
            while($ret_lab_table = $run_lab_query->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$ret_lab_table["f_id"]."</td>";
                echo "<td>".$ret_lab_table["lab_no"]."</td>";
                echo "<td>".$ret_lab_table["test_type"]."</td>";
                echo "<td>".$ret_lab_table["t_price"]."</td>";
                echo "<td>".$ret_lab_table["ordering_date"]."</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "0 results";
        }
    } else {
        // If patient ID doesn't exist, redirect to another page
        header("Location: input_id_lab_error.html");
    }
}

?>
    
<div class="goto-div"><a href="patients login view.html"><button class="back-to-homepage">Back to dashboard</button></a></div>
</body>
</html>
