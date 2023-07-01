<?php

$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

   
    $sql = "SELECT health_report FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $healthReportFilePath = $row["health_report"];

        
        if (file_exists($healthReportFilePath)) {
            header("Content-Disposition: attachment; filename=" . basename($healthReportFilePath));
            header("Content-Type: application/pdf");
            readfile($healthReportFilePath);
            exit;
        } else {
            echo "Health report not found.";
        }
    } else {
        echo "No user found with the provided email ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Fetch Health Report</title>
</head>
<body>
  <h2>Fetch Health Report</h2>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="email">Email ID:</label>
    <input type="email" id="email" name="email" required><br>

    <input type="submit" value="Fetch Report">
  </form>
</body>
</html>
