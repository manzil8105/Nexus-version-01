<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}

include("connection.php");

$post_id = $_GET['post_id'] ?? null;
$error = "";

if ($post_id) {
  $user_id = $_SESSION['user_id'];

  // Validate user ownership
  $postQuery = "SELECT * FROM Post WHERE post_id = $post_id AND user_id = $user_id";
  $postResult = mysqli_query($conn, $postQuery);

  if (mysqli_num_rows($postResult) > 0) {
    // Delete tags associated with the post
    $deleteTags = "DELETE FROM Post_to_Tag WHERE post_id = $post_id";
    mysqli_query($conn, $deleteTags);

    // Delete the post
    $deletePost = "DELETE FROM Post WHERE post_id = $post_id";
    if (mysqli_query($conn, $deletePost)) {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
      exit;
    } else {
      $error = "Error deleting the post: " . mysqli_error($conn);
    }
  } else {
    $error = "You are not authorized to delete this post or it does not exist.";
  }
} else {
  $error = "Invalid post ID.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Post</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">

  <!-- Navbar (reuse the same navbar as before) -->
  <nav class="bg-gray-800 p-4 shadow-md"> <!-- Add your navbar code here --> </nav>

  <main class="flex flex-col items-center justify-center flex-1 mt-20 p-4">
    <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl">
      <?php if ($error): ?>
        <p class="text-red-500"><?php echo $error; ?></p>
      <?php else: ?>
        <p class="text-green-500">Post deleted successfully.</p>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>