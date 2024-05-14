<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>dbconnect</title>
	<link rel="stylesheet" href="dbconnect.css">
</head>
<body>
	<div class="connect-style">
		<?php

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "dummy_healopharm";

		//creating connection

		$conn = new mysqli($servername, $username, $password);

		//check connection 
		if($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
			}
		else{
			mysqli_select_db($conn, $dbname);
			echo "Connection successful!";
			}


		?>
	</div>
</body>
</html>