<?php

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($post_id > 0 && in_array($action, ['like', 'dislike'])) {
        if ($action === 'like') {
            $sql = "UPDATE Post SET likes = likes + 1 WHERE post_id = $post_id";
        } elseif ($action === 'dislike') {
            $sql = "UPDATE Post SET dislikes = dislikes + 1 WHERE post_id = $post_id";
        }

        if (mysqli_query($conn, $sql)) {
            header("Location: fullpostview.php?post_id=$post_id");
            exit;
        } else {
            die("Failed to update: " . mysqli_error($conn));
        }
    } else {
        die("Invalid request.");
    }
} else {
    die("Invalid request method.");
}
