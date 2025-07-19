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
          header("Location: bookmark.php#$post_id");
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
        header("Location: bookmark.php#$post_id");
        exit;
      } else {
        die("Failed to update: " . mysqli_error($conn));
      }
    }
  } else {
    die("Invalid request.");
  }
}

$sql = "SELECT * FROM User WHERE user_id = " . $_SESSION['user_id'];
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$sql_posts = "SELECT p.*, u.name, u.role_on_site, GROUP_CONCAT(t.tag_name) AS tags
              FROM Post AS p
              JOIN User AS u ON p.user_id = u.user_id
              LEFT JOIN Post_to_Tag AS pt ON p.post_id = pt.post_id
              LEFT JOIN Tag AS t ON pt.tag_id = t.tag_id
              LEFT JOIN Bookmark AS b ON b.post_id = p.post_id
              WHERE b.user_id = " . $_SESSION["user_id"] . "
              GROUP BY p.post_id
              ORDER BY p.likes DESC";
$result_posts = mysqli_query($conn, $sql_posts);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-300">
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
      <a href="privateText.php"> <img src="message2.png" class="w-12 h-12"></a>
      <a href="groupText.php">
        <div><img src="Screenshot_2025-01-07_225140-removebg-preview.png" class="w-12 h-12"></div>
      </a>

      <a href="userprofile.php"> <img src="profile2.png" class="w-12 h-12"></a>
      <!-- logout -->
      <a href="logout.php"> <img src="logout-icon.svg" class="w-12 h-12"></a>
    </div>
  </nav>
  <!-- Main Content -->
  <main class="p-6">
    <div class="flex items-start bg-gray-800 p-4 rounded-lg">
      <div class="flex justify-between w-full">
        <div class="text-white p-4 rounded-lg flex items-center space-x-4">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQm3RFDZM21teuCMFYx_AROjt-AzUwDBROFww&s"
            alt="Profile Picture"
            class="h-28 rounded-md object-cover" />
          <div class="bg-gray-900 rounded-lg px-3 py-2">
            <h2 class="text-lg font-semibold"><?php echo $row["name"] ?></h2>
            <p class="text-gray-400"><?php echo $row["email"][0] ?><?php echo $row["user_id"] ?></p>
            <a
              href="mailto:manzilahsan81050@gmail.com"
              class="text-blue-400 hover:underline"><?php echo $row["email"] ?></a>
            <p class="text-red-500">
              &lt;explorer&gt; <span class="text-green-500">[38]</span>
            </p>
          </div>
          <div class="ml-auto grid gap-y-4">
            <a href="bookmark.php"
              class="flex items-center space-x-1 text-yellow-400 hover:text-yellow-300">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm12 2H7v14h10V5zm-5 4a1 1 0 011-1h2a1 1 0 010 2h-2a1 1 0 01-1-1zm-2 8a1 1 0 110-2h6a1 1 0 010 2H10zm-1-5H7a1 1 0 110-2h2a1 1 0 010 2z" />
              </svg>
              <span>Bookmarks</span>
            </a>

            <a
              href="userprofile.php"
              class="flex items-center space-x-1 text-yellow-400 hover:text-yellow-300">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M4 3h16a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2zm14 2H6v14h12V5zm-6 11a1 1 0 11-2 0v-4a1 1 0 112 0v4zm0-7a1 1 0 110-2h4a1 1 0 010 2h-4z" />
              </svg>
              <span>My Posts</span>
            </a>

            <!-- <button
              class="flex items-center space-x-1 text-green-400 hover:text-green-300">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
              </svg>
              <span>My Answers</span>
            </button> -->
          </div>
        </div>

        <!-- Option Button with Pop-up -->

      </div>
    </div>


    <!-- Post Section -->
    <section class="w-3/4 mt-6">
      <?php while ($row = mysqli_fetch_array($result_posts)) { ?>
        <div id="<?php echo $row["post_id"] ?>" class="bg-gray-800 rounded-lg p-4 mb-6 shadow-md border-2 border-yellow-500">
          <div class="flex items-center gap-2 mb-2">
            <img src="profile.png" alt="User" class="h-10 w-10 rounded-full">
            <div class="w-full">
              <div class="flex w-full justify-between">
                <h3 class="font-semibold"><?php echo $row["name"]; ?></h3>
                <?php
                if ($row["user_id"] == $_SESSION["user_id"]) {
                ?>
                  <div class="flex gap-4 underline">
                    <a href="edit.php">Edit</a>
                    <a href="delete.php">Delete</a>
                  </div>
                <?php
                } else {
                ?>

                  <!-- <a href="report.php">report</a> -->
                <?php
                }
                ?>
              </div>
              <p class="text-sm text-gray-400"><?php echo $row["role_on_site"]; ?></p>
            </div>
          </div>
          <h2 class="text-lg font-bold"> <a href=<?php echo 'fullpostview.php?post_id=' . $row["post_id"] ?>><?php echo $row["title"]; ?></a></h2>
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
            </div>

            <form action="hompage.php" method="GET" class="inline">
              <input type="hidden" name="tag" value="<?php echo "AI" ?>">
              <button class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-md mb-2">
                <?php echo $row["tags"]; ?>
              </button>
            </form>
          </div>
        </div>
      <?php } ?>
    </section>

    <!-- Delete Confirmation Pop-up -->
    <div
      id="deletePopup"
      class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center">
      <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">
          Are you sure you want to delete this post?
        </h2>
        <div class="flex justify-between">
          <button
            onclick="toggleDeletePopup()"
            class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">
            Delete
          </button>
          <button
            onclick="toggleDeletePopup()"
            class="bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded">
            Cancel
          </button>
        </div>
      </div>
    </div>

    <script>
      function togglePopup() {
        const popup = document.getElementById("popupWindow");
        popup.classList.toggle("hidden");
      }

      function toggleDeletePopup() {
        const deletePopup = document.getElementById("deletePopup");
        deletePopup.classList.toggle("hidden");
      }
    </script>
</body>

</html>