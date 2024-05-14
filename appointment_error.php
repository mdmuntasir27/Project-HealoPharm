<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Availability</title>
    <link rel='stylesheet' href='appointment_style.css'>
</head>
<body>
    <h2>Doctor appointments</h2>
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
        }
        
        $query = "SELECT reg_id, d_f_name, d_l_name, speciality, slot, capacity FROM doctor";
        $result = $conn->query($query);
        if ($result->num_rows>0){
            echo "<table border='1'>";
            echo "<tr><th>Reg ID</th><th>First Name</th><th>Last Name</th><th>Speciality</th><th>Slot</th><th>Capacity</th></tr>";
            while ($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row["reg_id"]."</td>";
                echo "<td>".$row["d_f_name"]."</td>";
                echo "<td>".$row["d_l_name"]."</td>";
                echo "<td>".$row["speciality"]."</td>";
                echo "<td>".$row["slot"]."</td>";
                echo "<td>".$row["capacity"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
    ?>
    
    <div class="goto-div">
        <a href="patients login view.html"><button class="goto-homepage">Back to Dashboard</button></a>
    </div>
    <div>
        <form action="appointment_book.php" method="post">
            <label for="p_id">Patient ID:</label>
            <input type="text" name="p_id" required>
            <label for="reg_id">Doctor's Reg. ID:</label>
            <input type="text" name="reg_id" required>
            <button type="submit">Book Appointment</button>
        </form>
    </div>
    <p class="error-message">Input your Patient ID and Doctor Reg. ID carefully!</p>
</body>
</html>