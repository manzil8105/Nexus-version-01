<?php


session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}
include("connection.php");

// Get post_id from the URL
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Handle like/dislike action
if (isset($_POST["action"])) {
  $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
  $action = isset($_POST['action']) ? $_POST['action'] : '';
  $user_id = $_SESSION['user_id']; // Assume user is logged in and session contains user_id

  if ($post_id > 0 && in_array($action, ['like', 'dislike'])) {
    // Check if the user already performed an action on this post
    $query = "SELECT action FROM User_Likes_Dislikes WHERE user_id = $user_id AND post_id = $post_id";
    $result = mysqli_query($conn, $query);
    $currentAction = $result ? mysqli_fetch_assoc($result)['action'] : null;

    if ($currentAction) {
      // If the user is changing their action
      if ($currentAction !== $action) {
        if ($currentAction === 'like') {
          // Remove a like and add a dislike
          $sql1 = "UPDATE Post SET likes = likes - 1, dislikes = dislikes + 1 WHERE post_id = $post_id";
        } elseif ($currentAction === 'dislike') {
          // Remove a dislike and add a like
          $sql1 = "UPDATE Post SET dislikes = dislikes - 1, likes = likes + 1 WHERE post_id = $post_id";
        }

        // Update the action in User_Likes_Dislikes table
        $sql2 = "UPDATE User_Likes_Dislikes SET action = '$action' WHERE user_id = $user_id AND post_id = $post_id";

        // Execute queries
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
          header("Location: fullpostview.php?post_id=$post_id#$post_id");
          exit;
        } else {
          die("Failed to update: " . mysqli_error($conn));
        }
      }
    } else {
      // If the user has not performed any action yet
      if ($action === 'like') {
        $sql1 = "UPDATE Post SET likes = likes + 1 WHERE post_id = $post_id";
      } elseif ($action === 'dislike') {
        $sql1 = "UPDATE Post SET dislikes = dislikes + 1 WHERE post_id = $post_id";
      }

      // Insert new record in User_Likes_Dislikes table
      $sql2 = "INSERT INTO User_Likes_Dislikes (user_id, post_id, action) VALUES ($user_id, $post_id, '$action')";

      // Execute queries
      if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        header("Location: fullpostview.php?post_id=$post_id#$post_id");
        exit;
      } else {
        die("Failed to update: " . mysqli_error($conn));
      }
    }
  } else {
    die("Invalid request.");
  }
}

// Handle bookmark action
if (isset($_POST['bookmark'])) {
  $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

  if ($post_id == $_SESSION['user_id']) {
    die("You cannot bookmark your own post.");
  }

  $sql = "SELECT * FROM Bookmark WHERE user_id = {$_SESSION['user_id']} AND post_id = $post_id";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) {
    $insertBookmark = "INSERT INTO Bookmark (user_id, post_id) VALUES ({$_SESSION['user_id']}, $post_id)";
    if (mysqli_query($conn, $insertBookmark)) {
      header("Location: fullpostview.php?post_id=$post_id#$post_id");
    } else {
      die("Failed to bookmark: " . mysqli_error($conn));
    }
  } else {
    die("You have already bookmarked this post.");
  }
}

// Fetch the post and its author's details from the database
$sql = "SELECT p.*, u.name, u.role_on_site, GROUP_CONCAT(t.tag_name) AS tags
        FROM Post AS p
        JOIN User AS u ON p.user_id = u.user_id
        LEFT JOIN Post_to_Tag AS pt ON p.post_id = pt.post_id
        LEFT JOIN Tag AS t ON pt.tag_id = t.tag_id
        WHERE p.post_id = $post_id";
$result = mysqli_query($conn, $sql);

// Check if the post exists
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
} else {
  die("Post not found.");
}

// Handle comment submission
if (isset($_POST['submit_comment'])) {
  $comment_text = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';
  if (!empty($comment_text) && $post_id > 0) {
    $user_id = $_SESSION['user_id']; // Get logged-in user ID
    $sql = "INSERT INTO Comments (comment_text, user_id, post_id) VALUES ('$comment_text', $user_id, $post_id)";
    if (!mysqli_query($conn, $sql)) {
      die("Failed to add comment: " . mysqli_error($conn));
    } else {
      header("Location: fullpostview.php?post_id=$post_id#$post_id");
      exit;
    }
  } else {
    echo "<script>alert('Comment cannot be empty');</script>";
  }
}

// Fetch comments for the post
$sql_comments = "SELECT c.comment_text, c.comment_id, u.name 
                 FROM Comments AS c 
                 JOIN User AS u ON c.user_id = u.user_id 
                 WHERE c.post_id = $post_id 
                 ORDER BY c.comment_id DESC";
$result_comments = mysqli_query($conn, $sql_comments);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($row["title"]); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-300">

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
          <input type="text" name="search" placeholder="Search Tags" value="<?php echo ""; ?>"
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

  <!-- Main Content -->
  <main class="p-6">
    <div class="bg-gray-800 rounded-lg p-4 mb-6 shadow-md border-2 border-yellow-500">
      <div class="flex justify-between">
        <!-- User Info -->
        <div class="flex items-center gap-2 mb-2">
          <img src="profile.png" alt="User" class="h-10 w-10 rounded-full">
          <div>
            <h3 class="font-semibold"><?php echo htmlspecialchars($row["name"]); ?></h3>
            <p class="text-sm text-gray-400"><?php echo htmlspecialchars($row["role_on_site"]); ?></p>
          </div>
        </div>
      </div>
      <!-- Post Title -->
      <h2 class="text-lg font-bold"><?php echo htmlspecialchars($row["title"]); ?></h2>
      <!-- Post Content -->
      <p class="text-gray-300 mt-4 bg-gray-900 p-4 rounded-md leading-relaxed">
        <?php echo nl2br(htmlspecialchars($row["post_text"])); ?>
      </p>
      <!-- Post Interactions -->
      <div class="flex items-center justify-between text-yellow-400 mt-4">
        <div class="flex space-x-6 items-center">
          <!-- Like Button -->
          <form action="" method="POST" class="inline">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <button type="submit" name="action" value="like" class="flex items-center space-x-1 hover:text-red-500">
              <span>❤️</span>
              <span><?php echo $row["likes"]; ?></span>
            </button>
          </form>
          <!-- Dislike Button -->
          <form action="" method="POST" class="inline">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <button type="submit" name="action" value="dislike" class="flex items-center space-x-1 hover:text-gray-500">
              <span>👎</span>
              <span><?php echo $row["dislikes"]; ?></span>
            </button>
          </form>
          <?php
          if ($row["user_id"] != $_SESSION["user_id"]) {
          ?>
            <form action="" method="POST">
              <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
              <button type="submit" name="bookmark" class="flex items-center space-x-1 hover:text-yellow-400">
                <span>🔖</span>
              </button>
            </form>
          <?php
          }
          ?>
        </div>
        <button class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-md"><?php echo $row["tags"]; ?></button>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-gray-800 rounded-lg p-4 mt-6 border-2 border-yellow-500">
      <h3 class="text-lg font-bold text-yellow-500 mb-4">Comments</h3>

      <!-- Display Comments -->
      <?php
      if ($result_comments && mysqli_num_rows($result_comments) > 0) {
        while ($comment = mysqli_fetch_assoc($result_comments)) {
      ?>
          <div class="mb-4 bg-gray-700 p-3 rounded-md">
            <p class="text-yellow-400 font-semibold"><?php echo htmlspecialchars($comment['name']); ?></p>
            <p class="text-gray-300"><?php echo htmlspecialchars($comment['comment_text']); ?></p>
          </div>
      <?php
        }
      } else {
        echo "<p class='text-gray-500'>No comments yet. Be the first to comment!</p>";
      }
      ?>

      <!-- Add Comment Form -->
      <form action="" method="POST" class="mt-4">
        <textarea name="comment_text" rows="3" placeholder="Write your comment here..."
          class="w-full p-3 bg-gray-700 text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
        <button type="submit" name="submit_comment"
          class="bg-yellow-500 text-gray-900 px-4 py-2 mt-2 rounded-md hover:bg-yellow-600">Add Comment</button>
      </form>
    </div>
  </main>
</body>

</html>