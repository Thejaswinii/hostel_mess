<?php
$host = "localhost";  // Database host
$username = "root";  // Database username
$password = "";  // Database password
$dbname = "user_management";  // Database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $reg_no = $_POST['reg_no'];
    $name = $_POST['name'];
    $ph_no = $_POST['ph_no'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $acc_type = $_POST['acc_type'];

    $query = "INSERT INTO users (reg_no, name, ph_no, mail, password, dob, gender, acc_type) 
              VALUES ('$reg_no', '$name', '$ph_no', '$mail', '$password', '$dob', '$gender', '$acc_type')";

    if ($conn->query($query) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
