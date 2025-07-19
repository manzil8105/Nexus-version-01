<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}

include("connection.php");

$post_id = $_GET['post_id'] ?? null;
$error = "";

// Fetch the post and its associated tags
if ($post_id) {
  $postQuery = "SELECT * FROM Post WHERE post_id = $post_id";
  $postResult = mysqli_query($conn, $postQuery);
  $post = mysqli_fetch_assoc($postResult);

  if (!$post) {
    $error = "Post not found.";
  } else {
    $tagsQuery = "SELECT t.tag_name FROM Tag t
                      JOIN Post_to_Tag pt ON t.tag_id = pt.tag_id
                      WHERE pt.post_id = $post_id";
    $tagsResult = mysqli_query($conn, $tagsQuery);
    $existingTags = [];
    while ($tag = mysqli_fetch_assoc($tagsResult)) {
      $existingTags[] = $tag['tag_name'];
    }
  }
} else {
  $error = "Invalid post ID.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $post_id) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $tagsInput = mysqli_real_escape_string($conn, $_POST['tags']);
  $user_id = $_SESSION['user_id'];

  // Validate user ownership
  if ($post['user_id'] != $user_id) {
    $error = "You are not authorized to edit this post.";
  } else {
    $tagsArray = array_map('trim', explode(',', $tagsInput));
    $validTags = [];

    foreach ($tagsArray as $tag) {
      $tagQuery = "SELECT * FROM Tag WHERE tag_name = '$tag'";
      $tagResult = mysqli_query($conn, $tagQuery);
      if (mysqli_num_rows($tagResult) > 0) {
        $validTags[] = $tag;
      } else {
        $error = "Tag '$tag' does not exist.";
      }
    }

    // If no error, update the post
    if (!$error) {
      $updatePost = "UPDATE Post SET title = '$title', post_text = '$content' WHERE post_id = $post_id";
      if (mysqli_query($conn, $updatePost)) {
        // Update tags
        $deleteTags = "DELETE FROM Post_to_Tag WHERE post_id = $post_id";
        mysqli_query($conn, $deleteTags);

        foreach ($validTags as $tag) {
          $tagQuery = "SELECT tag_id FROM Tag WHERE tag_name = '$tag'";
          $tagResult = mysqli_query($conn, $tagQuery);
          $tag_id = mysqli_fetch_assoc($tagResult)['tag_id'];

          $associateTag = "INSERT INTO Post_to_Tag (post_id, tag_id) VALUES ($post_id, $tag_id)";
          mysqli_query($conn, $associateTag);
        }

        header("Location: edit.php?post_id=$post_id");
        exit;
      } else {
        $error = "Error updating the post: " . mysqli_error($conn);
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Post</title>
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
        <form action="" method="POST">
          <input type="text" name="title" value="<?php echo $post['title']; ?>" placeholder="Title"
            class="w-full mb-4 px-4 py-2 bg-gray-900 text-yellow-400 rounded-md focus:outline-none">

          <textarea name="content" placeholder="Write your content here..."
            class="w-full h-40 px-4 py-2 bg-gray-900 text-white rounded-md focus:outline-none resize-none mb-4"><?php echo $post['post_text']; ?></textarea>

          <input type="text" name="tags" value="<?php echo implode(', ', $existingTags); ?>"
            placeholder="Tags (comma-separated)"
            class="w-full px-4 py-2 bg-gray-900 text-yellow-400 rounded-md focus:outline-none">

          <button type="submit"
            class="w-full bg-yellow-500 text-gray-900 py-2 mt-4 rounded-md font-medium focus:outline-none">
            Update Post
          </button>
        </form>
      <?php endif; ?>
    </div>
  </main>
</body>

</html>