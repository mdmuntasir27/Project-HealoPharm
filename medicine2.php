<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Medicines</title>
    <link rel='stylesheet' href='medicine_style.css'>
</head>
<body>
    <p class="yo-message">Successfully bought!</p>
    <h2>Buy Medicines</h2>
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
        
        $query = "SELECT * FROM medicine";
        $result = $conn->query($query);
        if ($result->num_rows>0){
            echo "<table border='1'>";
            echo "<tr><th>f_id</th><th>Name</th><th>Quantity</th><th>Price</th><th>Exp. Date</th></tr>";
            while ($row=$result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row["f_id"]."</td>";
                echo "<td>".$row["m_name"]."</td>";
                echo "<td>".$row["m_quantity"]."</td>";
                echo "<td>".$row["m_price"]."</td>";
                echo "<td>".$row["exp_date"]."</td>";
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
        <form action="medicine_buy.php" method="post">
            <label for="p_id">Patient ID:</label>
            <input type="text" name="p_id" required>
            <label for="f_id">Medicine's f_id:</label>
            <input type="text" name="f_id" required>
            <label for="s_quantity">Quantity to buy:</label>
            <input type="text" name="s_quantity" required>
            <button type="submit">Buy</button>
        </form>
    </div>
</body>
</html>