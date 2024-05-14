<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your appointments</title>
    <link rel='stylesheet' href='appointment_style.css'>
</head>
<body>
	<h2>Your appointment</h2>
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
			$consultation_query = "SELECT d.reg_id, d.d_f_name, d.d_l_name, d.d_mail, d.d_phone, d.speciality, c.con_time, c.con_date from doctor d inner join consultations c on c.d_reg_no=d.reg_id inner join patient p on p.id=c.p_id where c.p_id=$p_id";
			$run_consultation_query = $conn->query($consultation_query);
			if ($run_consultation_query->num_rows>0){
				echo "<table border='1'>";
				echo "<tr><th>Registration ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone No.</th><th>Speciality</th><th>Slot</th><th>Date</th></tr>";
				while($ret_consultation_table=$run_consultation_query->fetch_assoc()){
					echo "<tr>";
					echo "<td>".$ret_consultation_table["reg_id"]."</td>";
					echo "<td>".$ret_consultation_table["d_f_name"]."</td>";
					echo "<td>".$ret_consultation_table["d_l_name"]."</td>";
					echo "<td>".$ret_consultation_table["d_mail"]."</td>";
					echo "<td>".$ret_consultation_table["d_phone"]."</td>";
					echo "<td>".$ret_consultation_table["speciality"]."</td>";
					echo "<td>".$ret_consultation_table["con_time"]."</td>";
					echo "<td>".$ret_consultation_table["con_date"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			} else{
				echo "0 results";
			}
		} else{
			header("location: input_id_appointment_showError.html");
		}
	}
    ?>
	<div class="goto-div"><a href="patients login view.html"><button>Go to dashboard</button></a></div>
</body>
</html>