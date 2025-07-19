<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}

include("connection.php");

// Handle like/dislike action
if (isset($_POST["action"])) {
  $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
  $action = isset($_POST['action']) ? $_POST['action'] : '';
  $user_id = $_SESSION['user_id'];

  if ($post_id > 0 && in_array($action, ['like', 'dislike'])) {
    $query = "SELECT action FROM User_Likes_Dislikes WHERE user_id = $user_id AND post_id = $post_id";
    $result = mysqli_query($conn, $query);
    $currentAction = $result ? mysqli_fetch_assoc($result)['action'] : null;

    if ($currentAction) {
      if ($currentAction !== $action) {
        if ($currentAction === 'like') {
          $sql1 = "UPDATE Post SET likes = likes - 1, dislikes = dislikes + 1 WHERE post_id = $post_id";
        } elseif ($currentAction === 'dislike') {
          $sql1 = "UPDATE Post SET dislikes = dislikes - 1, likes = likes + 1 WHERE post_id = $post_id";
        }
        $sql2 = "UPDATE User_Likes_Dislikes SET action = '$action' WHERE user_id = $user_id AND post_id = $post_id";
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
          header("Location: hompage.php#$post_id");
          exit;
        } else {
          die("Failed to update: " . mysqli_error($conn));
        }
      }
    } else {
      if ($action === 'like') {
        $sql1 = "UPDATE Post SET likes = likes + 1 WHERE post_id = $post_id";
      } elseif ($action === 'dislike') {
        $sql1 = "UPDATE Post SET dislikes = dislikes + 1 WHERE post_id = $post_id";
      }
      $sql2 = "INSERT INTO User_Likes_Dislikes (user_id, post_id, action) VALUES ($user_id, $post_id, '$action')";
      if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        header("Location: hompage.php#$post_id");
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
      header("Location: hompage.php#$post_id");
    } else {
      die("Failed to bookmark: " . mysqli_error($conn));
    }
  } else {
    die("You have already bookmarked this post.");
  }
}

$titleSearch = isset($_GET['titleSearch']) ? mysqli_real_escape_string($conn, $_GET['titleSearch']) : '';
$tagSearch = isset($_GET['tagSearch']) ? mysqli_real_escape_string($conn, $_GET['tagSearch']) : '';
$tagPostSearch = isset($_GET['tagPostSearch']) ? mysqli_real_escape_string($conn, $_GET['tagPostSearch']) : '';
$tagFilter = isset($_GET['tag']) ? mysqli_real_escape_string($conn, $_GET['tag']) : '';

if (!empty($tagFilter)) {
  $sql = "SELECT p.*, u.name, u.role_on_site, GROUP_CONCAT(t.tag_name) AS tags
          FROM Post AS p
          JOIN User AS u ON p.user_id = u.user_id
          LEFT JOIN Post_to_Tag AS pt ON p.post_id = pt.post_id
          LEFT JOIN Tag AS t ON pt.tag_id = t.tag_id
          WHERE p.title LIKE '%$titleSearch%' AND t.tag_name = '$tagFilter'
          GROUP BY p.post_id
          ORDER BY p.likes DESC";
} else {
  $sql = "SELECT p.*, u.name, u.role_on_site, GROUP_CONCAT(t.tag_name) AS tags
          FROM Post AS p
          JOIN User AS u ON p.user_id = u.user_id
          LEFT JOIN Post_to_Tag AS pt ON p.post_id = pt.post_id
          LEFT JOIN Tag AS t ON pt.tag_id = t.tag_id
          WHERE p.title LIKE '%$titleSearch%'
          GROUP BY p.post_id
          ORDER BY p.likes DESC";
}
$result = mysqli_query($conn, $sql);

// Fetch all tags for tag library
$tagsQuery = "SELECT * FROM Tag WHERE tag_name LIKE '%$tagSearch%'";
$tagsResult = mysqli_query($conn, $tagsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-yellow-500 flex flex-col min-h-screen">
  <!-- Navbar -->
  <nav class="bg-gray-800 p-4 flex items-center justify-between shadow-md">
    <div><a href="hompage.php"><img src="home.png" alt="Home" class="h-8"></a></div>
    <div class="flex-1 mx-8">
      <div class="bg-gray-700 border border-yellow-500 rounded-full flex items-center px-3 py-1">
        <img src="search.png" alt="Search" class="w-6 h-6 mr-2">
        <form action="hompage.php" method="GET" class="w-full">
          <input type="text" name="titleSearch" placeholder="Search Tags" value="<?php echo htmlspecialchars($titleSearch); ?>"
            class="bg-transparent text-yellow-500 w-full focus:outline-none">
        </form>
      </div>
    </div>
    <div class="flex space-x-4">
      <a href="post.php"><img src="draft.png" class="w-12 h-12"></a>
      <a href="groupText.php"><img src="message2.png" class="w-12 h-12"></a>
      <a href="userprofile.php"><img src="profile2.png" class="w-12 h-12"></a>
      <a href="logout.php"><img src="logout-icon.svg" class="w-12 h-12"></a>
    </div>
  </nav>

  <main class="flex gap-4 p-6 mt-2 rounded-lg">
    <!-- Posts Section -->
    <section class="w-3/4">
      <?php while ($row = mysqli_fetch_array($result)) { ?>
        <div id="<?php echo $row["post_id"] ?>" class="bg-gray-800 rounded-lg p-4 mb-6 shadow-md border-2 border-yellow-500">
          <div class="flex items-center gap-2 mb-2">
            <img src="profile.png" alt="User" class="h-10 w-10 rounded-full">
            <div class="w-full">
              <div class="flex w-full justify-between">
                <h3 class="font-semibold"><?php echo $row["name"]; ?></h3>
                <?php if ($row["user_id"] == $_SESSION["user_id"]) { ?>
                  <div class="flex gap-4 underline">
                    <a href=<?php echo "edit.php?post_id=" . $row["post_id"] ?>>Edit</a>
                    <a href=<?php echo "delete.php?post_id=" . $row["post_id"] ?>>Delete</a>
                  </div>
                <?php } ?>
              </div>
              <p class="text-sm text-gray-400"><?php echo $row["role_on_site"]; ?></p>
            </div>
          </div>
          <h2 class="text-lg font-bold">
            <a href=<?php echo 'fullpostview.php?post_id=' . $row["post_id"] ?>>
              <?php echo $row["title"]; ?>
            </a>
          </h2>
          <span><?php echo $row["state"]; ?></span>
          <p class="text-gray-300 mt-2 bg-gray-900 p-4 h-[200px] text-wrap w-full">
            <?php
              $truncatedText = substr($row["post_text"], 0, 250);
              echo $truncatedText;
              if (strlen($row["post_text"]) > 250) {
                echo '... <a href="fullpostview.php?post_id=' . $row["post_id"] . '" class="text-yellow-400">See More</a>';
              }
            ?>
          </p>
          <div class="flex items-center justify-between text-yellow-400 mt-4">
            <div class="flex gap-4">
              <form action="" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                <button type="submit" name="action" value="like" class="flex items-center space-x-1 hover:text-red-500">
                  <span>❤️</span>
                  <span><?php echo $row["likes"]; ?></span>
                </button>
              </form>
              <form action="" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                <button type="submit" name="action" value="dislike" class="flex items-center space-x-1 hover:text-gray-500">
                  <span>👎</span>
                  <span><?php echo $row["dislikes"]; ?></span>
                </button>
              </form>
              <?php if ($row["user_id"] != $_SESSION["user_id"]) { ?>
                <form action="" method="POST">
                  <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                  <button type="submit" name="bookmark" class="flex items-center space-x-1 hover:text-yellow-400">
                    <span>🔖</span>
                  </button>
                </form>
              <?php } ?>
            </div>
            <div class="flex flex-wrap gap-2">
              <?php
              $tagArray = explode(",", $row["tags"]);
              foreach ($tagArray as $tag) {
              ?>
                <form action="hompage.php" method="GET" class="inline">
                  <input type="hidden" name="tag" value="<?php echo trim($tag); ?>">
                  <button class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-md mb-2"><?php echo trim($tag); ?></button>
                </form>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </section>

    <!-- Tag Library Section -->
    <aside class="w-1/4 bg-gray-800 rounded-lg p-4 shadow-md border-2 border-yellow-500">
      <h2 class="text-xl font-bold mb-4">📚 Tag Library</h2>
      <div class="flex flex-wrap gap-2 text-gray-100 mt-2">
        <form action="hompage.php" method="GET" class="mb-4 w-full">
          <input type="text" name="tagSearch" placeholder="Search Tags" value="<?php echo htmlspecialchars($tagSearch); ?>"
            class="w-full px-3 py-2 bg-gray-900 text-yellow-400 placeholder-gray-500 rounded-md focus:outline-none">
        </form>
        <?php while ($tag = mysqli_fetch_assoc($tagsResult)) { ?>
          <form action="hompage.php" method="GET">
            <input type="hidden" name="tag" value="<?php echo $tag['tag_name']; ?>">
            <button class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-md"><?php echo $tag['tag_name']; ?></button>
          </form>
        <?php } ?>
      </div>
    </aside>
  </main>
</body>
</html>
