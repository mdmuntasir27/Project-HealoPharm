<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="p_login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient ID</title>
</head>
<body>
    <div class="container">
        <h2>Patient ID</h2>
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
        
        $conn->close();
    ?>
    
    <div>
        <form action="payment.php" method="post">
            <h1 style="color: red; font-size: 16px;">INCORRECT Patient ID!</h1>
            <div class="input-group">
                <label for="id">Patient ID:</label>
                <input type="text" id="id" name="id" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>    
</body>
</html>
