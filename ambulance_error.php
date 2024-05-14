<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance Services</title>
    <link rel='stylesheet' href='appointment_style.css'>
</head>
<body>
    <h2>Ambulance Services</h2>
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
        
        $query = "SELECT f_id, amb_no, a_time, a_price, a_availability FROM ambulance";
        $result = $conn->query($query);
        if ($result->num_rows>0){
            echo "<table border='1'>";
            echo "<tr><th>f_id</th><th>Ambulance Number</th><th>Ambulance Time</th><th>Ambulance Price</th><th>Ambulance Availability</th></tr>";
            while ($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row["f_id"] . "</td>";
                echo "<td>" . $row["amb_no"] . "</td>";
                echo "<td>" . $row["a_time"] . "</td>";
                echo "<td>" . $row["a_price"] . "</td>";
                echo "<td>" . $row["a_availability"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
    ?>
    
    <div class="goto-div">
        <a href="patients login view.html"><button class="goto-homepage">Back to dashboard</button></a>
    </div>
    <div>
        <form action="ambulance_book.php" method="post">
            <label for="f_id">f_ID:</label>
            <input type="text" name="f_id" required>
            <label for="p_id">Patient ID:</label>
            <input type="text" name="p_id" required>
            <button type="submit">Book Ambulance</button>
        </form>
        <p class="error-message">Enter p_id and f_id carefully</p>
    </div>
</body>
</html>

