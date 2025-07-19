<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$sender_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    $stmt = mysqli_prepare($conn, "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iis", $sender_id, $receiver_id, $message);
    mysqli_stmt_execute($stmt);
    
    echo json_encode(['success' => true]);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
    mysqli_stmt_bind_param($stmt, "iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    echo json_encode($messages);
}
?>
