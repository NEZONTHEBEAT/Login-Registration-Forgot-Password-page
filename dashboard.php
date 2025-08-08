<?php
session_start();

// যদি লগইন করা না থাকে, তাহলে login.php তে পাঠানো হবে
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome Dashboard</title>
  <style>
    body {
      background: #111;
      color: white;
      font-family: 'Poppins', sans-serif;
      text-align: center;
      padding-top: 100px;
    }

    .box {
      background: #222;
      padding: 40px;
      border-radius: 10px;
      display: inline-block;
      box-shadow: 0 0 10px rgba(255,255,255,0.1);
    }

    a {
      color: #ff1e00;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }

    .logout-btn {
      background-color: red;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 15px;
    }
    .logout-btn:hover {
      background-color: darkred;
    }
  </style>
</head>
<body>

<div class="box">
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
  <p>You are now logged in to your dashboard.</p>

  <form action="logout.php" method="post">
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</div>

</body>
</html>
