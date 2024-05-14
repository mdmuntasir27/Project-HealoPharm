<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="lab.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Services</title>
</head>
<body>
    <div class="logo-container">
        <img src="HealoPharm.png" alt="HealoPharm Logo" class="logo">
    </div>
    <div class="container">
        <h2>Lab Services</h2>
        <table>
            <thead>
                <tr>
                    <th>f_id</th>
                    <th>Lab No</th>
                    <th>Test Type</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dummy_healopharm";
                $conn = new mysqli($servername, $username, $password, $dbname);
                //check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                // Query to fetch data from lab table
                $query = "SELECT f_id, lab_no, test_type, t_price FROM lab";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<table border='1'>"; 
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["f_id"] . "</td>";
                        echo "<td>" . $row["lab_no"] . "</td>";
                        echo "<td>" . $row["test_type"] . "</td>";
                        echo "<td>" . $row["t_price"] . "</td>";
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
                    <h2>Add Test:</h2>
                    <form action="lab_buy.php" method="post">
                        <label for="f_id">f_id:</label>
                        <input type="text" name="f_id" required>
                        <label for="p_id">Patient ID:</label>
                        <input type="text" name="p_id" required>
                        <button type="submit">Add</button>
                    </form>
                </div> 
            </tbody>
        </table>
        <p class="emotional-damage">Please enter f_id or p_id carefully!</p>
    </div>
</body>
</html>
