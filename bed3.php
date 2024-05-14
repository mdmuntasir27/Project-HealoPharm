<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="bed.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed Services</title>
</head>
<body>
    <p class="failed">This bed is already booked!</p>
    <div class="container">
        <div class="logo-container">
            <img src="HealoPharm.png" alt="HealoPharm Logo" class="logo">
        </div>
        <h2>Bed Services</h2>
        <table>
            <thead>
                <tr>
                    <th>f_id</th>
                    <th>Bed No</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Days booked</th>
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
                $query = "SELECT * FROM bed";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<table border='1'>"; 
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["f_id"] . "</td>";
                        echo "<td>" . $row["bed_no"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["days"] . "</td>";
                        echo "<td>" . $row["b_price"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
                <div class="goto-div">
                    <a href="patients login view.html"><button>Back to Dashboard</button></a>
                </div>
                <div>
                    <h2>Add Test:</h2>
                    <form action="bed_book.php" method="post">
                        <label for="f_id">f_id:</label>
                        <input type="text" name="f_id" required>
                        <label for="p_id">Patient ID:</label>
                        <input type="text" name="p_id" required>
                        <label for="days">Days to stay:</label>
                        <input type="text" name="days" required>
                        <button type="submit">Book</button>
                    </form>
                </div>  
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>
