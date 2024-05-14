<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Successful</title>
    <link rel="stylesheet" href="signup2.css">
</head>
<body>
    <div class="container">
        <h1>Congratulations! Your sign up is successful.</h1>
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
            else{
                mysqli_select_db($conn, $dbname);
                }
            $query1 = "SELECT MAX(id) as max_id FROM patient";
            $result = mysqli_query($conn, $query1);
            
            if($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $patient_id = $row['max_id'];
                
                $query1 = "INSERT INTO billing_cart (p_id) VALUES ($patient_id)";
                $result1 = mysqli_query($conn, $query1);

                if($result1) {
                    $query2 = "SELECT MAX(cart_id) as max_cart FROM billing_cart";
                    $result2 = mysqli_query($conn, $query2);
                    
                    if($result2 && mysqli_num_rows($result2)>0){
                        $row2 = mysqli_fetch_assoc($result2);
                        $cart_id = $row2['max_cart'];
                        echo "<p>Your patient ID is: $patient_id and your cart ID is: $cart_id. Please remember those ID's because you need them further. Do not share those ID's with others.</p>";
                    }
                    else {
                        echo "<p>Failed to retrieve cart ID. Please contact support.</p>";
                    }
                }
                else {
                    echo "Error: " . mysqli_error($conn);
                }
                
            } else {
                echo "<p>Failed to retrieve patient ID. Please contact support.</p>";
            }
        ?>
        <button onclick="window.location.href='p_login.html'" class="login-button">Log in</button>

    </div>
</body>
</html>
