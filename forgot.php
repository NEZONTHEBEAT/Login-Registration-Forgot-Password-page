<?php
session_start();

// Database configuration
$servername = "localhost";
$dbname = "registrationform"; // ডাটাবেস নাম
$username = "root"; // সাধারণত localhost এ root হয়
$password = ""; // সাধারণত ফাঁকা থাকে

try {
    // Database connection (PDO)
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// যদি ফর্ম সাবমিট হয়
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);

    // ইনপুট যাচাই
    if (empty($email) || empty($new_password)) {
        $_SESSION['error'] = "❌ All fields are required.";
        header("Location: forgot.html");
        exit();
    }

    // ইমেইল আছে কিনা চেক
    $stmt = $conn->prepare("SELECT * FROM userregistration WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // পাসওয়ার্ড হ্যাশ
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // পাসওয়ার্ড আপডেট
        $update = $conn->prepare("UPDATE userregistration SET password = :password WHERE email = :email");
        $update->bindParam(':password', $hashed_password);
        $update->bindParam(':email', $email);

        if ($update->execute()) {
            $_SESSION['success'] = "✅ Password updated successfully! Please log in.";
            header("Location: login.html");
            exit();
        } else {
            $_SESSION['error'] = "❌ Failed to update password.";
            header("Location: forgot.html");
            exit();
        }
    } else {
        $_SESSION['error'] = "❌ Email not found in our system.";
        header("Location: forgot.html");
        exit();
    }
} else {
    header("Location: forgot.html");
    exit();
}
?>
