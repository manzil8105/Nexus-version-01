<?php
session_start();
require_once 'connection.php';

$current_id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT user_id, name FROM User WHERE user_id != ?");
mysqli_stmt_bind_param($stmt, "i", $current_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
?>
