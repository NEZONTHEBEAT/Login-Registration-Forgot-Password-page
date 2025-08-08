<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//  Database connection
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "registrationform"; // Ensure this DB exists in phpMyAdmin

//  Create a connection
$conn = new mysqli($servername, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$fullname = $username = $email = $phone = $country = $gender = "";
$password = ""; // Plain password (will hash it)
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"] ?? '');
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $phonenumber = trim($_POST["phonenumber"] ?? '');
    $country = trim($_POST["country"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $gender = trim($_POST["gender"] ?? '');

    // ✅ Validation (basic)
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // ✅ Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Insert into DB
        $stmt = $conn->prepare("INSERT INTO userregistration (fullname, username, email, phonenumber, country, password, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullname, $username, $email, $phone, $country, $hashedPassword, $gender);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

$conn->close();
?>
