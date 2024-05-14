<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel='stylesheet' href='appointment_style.css'>
</head>
<body>
    <h2>Payment</h2>
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
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $p_id = (int)$_POST['id'];
            $query = "SELECT total_amount FROM billing_cart where p_id=$p_id";
            $result = $conn->query($query);
            if ($result->num_rows>0){
                echo "<table border='1'>";
                echo "<tr><th>Amount to be Paid</th></tr>";
                while ($row=$result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["total_amount"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                header("Location: incorrect_p_id.php");
                exit();
            }
            $conn->close();
        }
    ?>
    <div class="goto-div">
        <a href="patients login view.html"><button class="goto-homepage">Back to Dashboard</button></a>
    </div>
    
    
    <div>
        <form action="payment_2.php" method="post">
            <label for="p_id">Patient ID:</label>
            <input type="text" name="p_id" required>
            <label for="amount">Amount:</label>
            <input type="text" name="amount" required>
            <button type="submit">Pay</button>
        </form>
    </div>
</body>
</html>
