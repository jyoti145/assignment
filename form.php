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
    $name = $_POST["name"];
    $age = $_POST["age"];
    $weight = $_POST["weight"];
    $email = $_POST["email"];

  
    $targetDir = "uploads/";
    $fileName = basename($_FILES["healthReport"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    move_uploaded_file($_FILES["healthReport"]["tmp_name"], $targetFilePath);

    $sql = "INSERT INTO users (name, age, weight, email, health_report) VALUES ('$name', '$age', '$weight', '$email', '$targetFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>PHP-MySQL Form</title>
</head>
<body>
  <h2>PHP-MySQL Form</h2>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br>

    <label for="weight">Weight:</label>
    <input type="number" id="weight" name="weight" required><br>

    <label for="email">Email ID:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="healthReport">Upload Health Report:</label>
    <input type="file" id="healthReport" name="healthReport" required><br>

    <input type="submit" value="Submit">
  </form>
</body>
</html>
