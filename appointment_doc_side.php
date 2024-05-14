<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients for consultation</title>
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
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            $d_reg_no = (int)$_POST['d_reg_no'];
            $con_date = date("Y-m-d");
            $query = "SELECT p.id, p.p_f_name, p.p_l_name, p.DoB, p.gender, p.p_mail, YEAR(CURDATE())-YEAR(p.DoB) AS AGE FROM patient p INNER JOIN consultations c ON p.id=c.p_id WHERE c.d_reg_no=$d_reg_no AND c.con_date='$con_date'";
            $result = $conn->query($query);
            if ($result->num_rows>0){
                echo "<table border='1'>";
                echo "<tr><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Gender</th><th>Email</th><th>Age</th></tr>";
                while ($row=$result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["p_f_name"]."</td>";
                    echo "<td>".$row["p_l_name"]."</td>";
                    echo "<td>".$row["DoB"]."</td>";
                    echo "<td>".$row["gender"]."</td>";
                    echo "<td>".$row["p_mail"]."</td>";
                    echo "<td>".$row["AGE"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        }
        $conn->close();
    ?>
    
    <div class="goto-div">
        <a href="d.loginview.html"><button class="goto-homepage">Back to Dashboard</button></a>
    </div>
    <div>
        <form action="appointment_func_doc_side.php" method="post">
            <label for="p_id">Patient ID:</label>
            <input type="text" name="p_id" required>
            <label for="reg_id">Doctor's Reg. ID:</label>
            <input type="text" name="reg_id" required>
            <button type="submit">Checked</button>
        </form>
    </div>
</body>
</html>