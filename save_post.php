<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: first.php");
    exit;
}

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $user_id = $_SESSION['user_id']; // Replace with the logged-in user's ID

    // Insert the post into the database
    $insertPost = "INSERT INTO Post (title, post_text, user_id) VALUES ('$title', '$content', $user_id)";
    if (mysqli_query($conn, $insertPost)) {
        $post_id = mysqli_insert_id($conn);

        // Handle tags
        $tagsArray = array_map('trim', explode(',', $tags));
        foreach ($tagsArray as $tagName) {
            // Check if tag exists
            $tagQuery = "SELECT tag_id FROM Tag WHERE tag_name = '$tagName'";
            $tagResult = mysqli_query($conn, $tagQuery);
            if (mysqli_num_rows($tagResult) > 0) {
                $tagRow = mysqli_fetch_assoc($tagResult);
                $tag_id = $tagRow['tag_id'];
            } else {
                // Insert new tag
                $insertTag = "INSERT INTO Tag (tag_name) VALUES ('$tagName')";
                mysqli_query($conn, $insertTag);
                $tag_id = mysqli_insert_id($conn);
            }

            // Associate tag with post
            $associateTag = "INSERT INTO Post_to_Tag (post_id, tag_id) VALUES ($post_id, $tag_id)";
            mysqli_query($conn, $associateTag);
        }

        header("Location: hompage.php");
        exit;
    } else {
        die("Error saving post: " . mysqli_error($conn));
    }
}
