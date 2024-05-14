<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicines bought</title>
    <link rel='stylesheet' href='medicine_show_style.css'>
</head>
<body>
	<h2>Medicines</h2>
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
			$medicine_query = "SELECT m.f_id, m.m_name, m.exp_date, a.s_quantity, a.s_price, a.ordering_date from medicine m inner join avails a on m.f_id=a.f_id inner join patient p on p.id=a.p_id where p.id=$p_id";
			$run_medicine_query = $conn->query($medicine_query);
			if ($run_medicine_query->num_rows>0){
				echo "<table border='1'>";
				echo "<tr><th>f_id</th><th>Medicine Name</th><th>Expiry date</th><th>Quantity</th><th>Total price</th><th>Ordering date</th></tr>";
				while($ret_medicine_table=$run_medicine_query->fetch_assoc()){
					echo "<tr>";
					echo "<td>".$ret_medicine_table["f_id"]."</td>";
					echo "<td>".$ret_medicine_table["m_name"]."</td>";
					echo "<td>".$ret_medicine_table["exp_date"]."</td>";
					echo "<td>".$ret_medicine_table["s_quantity"]."</td>";
					echo "<td>".$ret_medicine_table["s_price"]."</td>";
                    echo "<td>".$ret_medicine_table["ordering_date"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else{
				echo "0 results";
			}
		} else{
			header("location: id_input_medicine2.html");
		}
	}
    ?>
	<div class="goto-div"><a href="patients login view.html"><button>Go to dashboard</button></a></div>
</body>
</html>