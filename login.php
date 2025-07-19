<?php
session_start();
include("connection.php");

if (isset($_POST["login"])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Check if the user exists
  $sql = "SELECT * FROM User WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    // Verify password
    if ($password == $user['password']) {
      // Set session variables
      $_SESSION['user_id'] = $user['user_id'];

      // Redirect to homepage
      header("Location: hompage.php");
      exit;
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "User not found.";
  }
}
