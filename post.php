<?php

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}

include("connection.php");

// Fetch existing tags for suggestions
$tagsQuery = "SELECT * FROM Tag";
$tagsResult = mysqli_query($conn, $tagsQuery);
$tags = [];
while ($tag = mysqli_fetch_assoc($tagsResult)) {
  $tags[] = $tag['tag_name'];
}

// Handle form submission
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $content = mysqli_real_escape_string($conn, $_POST['content']);
  $tagsInput = mysqli_real_escape_string($conn, $_POST['tags']);
  $user_id = 1; // Replace with logged-in user's ID

  // Validate tags
  $tagsArray = array_map('trim', explode(',', $tagsInput));
  $validTags = [];
  foreach ($tagsArray as $tag) {
    $tagQuery = "SELECT * FROM Tag WHERE tag_name = '$tag'";
    $tagResult = mysqli_query($conn, $tagQuery);
    if (mysqli_num_rows($tagResult) > 0) {
      $validTags[] = $tag;
    } else {
      $error = "Tag '$tag' does not exist. Please add a valid tag.";
    }
  }

  // If no error, save the post
  if (!$error) {
    $insertPost = "INSERT INTO Post (title, post_text, user_id) VALUES ('$title', '$content', $user_id)";
    if (mysqli_query($conn, $insertPost)) {
      $post_id = mysqli_insert_id($conn);

      // Link tags to the post
      foreach ($validTags as $tag) {
        $tagQuery = "SELECT tag_id FROM Tag WHERE tag_name = '$tag'";
        $tagResult = mysqli_query($conn, $tagQuery);
        $tag_id = mysqli_fetch_assoc($tagResult)['tag_id'];

        $associateTag = "INSERT INTO Post_to_Tag (post_id, tag_id) VALUES ($post_id, $tag_id)";
        mysqli_query($conn, $associateTag);
      }

      header("Location: hompage.php");
      exit;
    } else {
      $error = "Error saving the post: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post Draft</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function suggestTags(input) {
      const suggestions = document.getElementById('tagSuggestions');
      const tags = <?php echo json_encode($tags); ?>;
      const value = input.value.toLowerCase();
      suggestions.innerHTML = '';
      if (value) {
        tags.filter(tag => tag.toLowerCase().includes(value)).forEach(tag => {
          const suggestion = document.createElement('div');
          suggestion.className = 'px-3 py-1 bg-gray-700 text-yellow-400 rounded-md cursor-pointer';
          suggestion.textContent = tag;
          suggestion.onclick = () => {
            input.value = tag;
            suggestions.innerHTML = '';
          };
          suggestions.appendChild(suggestion);
        });
      }
    }
  </script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">

  <!-- Navbar -->
  <!-- Navbar -->
  <nav class="bg-gray-800 p-4 flex items-center justify-between shadow-md">
    <div>
      <a href="hompage.php"><img src="home.png" alt="Home" class="h-8"></a>
    </div>
    <div class="flex-1 mx-8">
      <div class="bg-gray-700 border border-yellow-500 rounded-full flex items-center px-3 py-1">
        <img src="search.png" alt="Search" class="w-6 h-6 mr-2">
        <form action="hompage.php" method="GET" class="w-full">
          <input type="text" name="search" placeholder="Search Tags" value=""
            class="bg-transparent text-yellow-500 w-full focus:outline-none">
        </form>
      </div>
    </div>
    <div class="flex space-x-4">

      <a href="post.php"> <img src="draft.png" class="w-12 h-12"></a>
      <a href="groupText.php">
        <img src="message2.png" class="w-12 h-12">
      </a>

      <a href="userprofile.php"> <img src="profile2.png" class="w-12 h-12"></a>
      <!-- logout -->
      <a href="logout.php"> <img src="logout-icon.svg" class="w-12 h-12"></a>
    </div>
  </nav>
  <form action="save_post.php" method="POST">
    <main class="flex flex-col items-center justify-center flex-1 mt-20 p-4">
      <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-2xl">
        <!-- Title Input -->
        <input
          type="text"
          name="title"
          placeholder="Title"
          class="w-full mb-4 px-4 py-2 bg-gray-900 text-yellow-400 placeholder-gray-500 rounded-md focus:outline-none">

        <!-- Content Input -->
        <textarea
          name="content"
          placeholder="Write your content here..."
          class="w-full h-40 px-4 py-2 bg-gray-900 text-white placeholder-gray-500 rounded-md focus:outline-none resize-none mb-4"></textarea>

        <!-- Tags Input with Suggestions -->
        <div class="relative">
          <input
            type="text"
            oninput="suggestTags(this)"
            placeholder="Add Tags (comma separated)"
            name="tags"
            class="w-full px-4 py-2 bg-gray-900 text-yellow-400 placeholder-gray-500 rounded-md focus:outline-none">
          <div id="tagSuggestions" class="absolute bg-gray-800 mt-1 w-full rounded-md"></div>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
          <p class="text-red-500 mt-2"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-yellow-500 text-gray-900 py-2 mt-4 rounded-md font-medium focus:outline-none">
          Save Draft
        </button>
      </div>
    </main>
  </form>
</body>

</html>