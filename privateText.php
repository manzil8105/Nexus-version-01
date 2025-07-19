<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: first.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Chat - Knowledge Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex flex-col">
    <!-- Navbar -->
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
          <input type="text" name="search" placeholder="Search Tags" value="<?php echo htmlspecialchars($searchQuery); ?>"
            class="bg-transparent text-yellow-500 w-full focus:outline-none">
        </form>
      </div>
    </div>
    <div class="flex space-x-4">
      
      <a href="post.php"> <img src="draft.png" class="w-12 h-12"></a>
      <a href="privateText.php"> <img src="message2.png" class="w-12 h-12"></a>
      <a href="groupText.php"> <div  ><img src="Screenshot_2025-01-07_225140-removebg-preview.png" class="w-12 h-12"></div></a>
      
      <a href="userprofile.php"> <img src="profile2.png" class="w-12 h-12"></a>
      <!-- logout -->
      <a href="logout.php"> <img src="logout-icon.svg" class="w-12 h-12"></a>
    </div>
  </nav>
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-gray-800 p-4 h-full overflow-y-auto">
            <!-- Search Bar -->
            <div class="bg-gray-700 border border-yellow-500 rounded-full p-2 flex items-center mb-4">
                <img src="search.png" class="w-6 h-6 mr-2">
                <input 
                    type="text" 
                    class="bg-transparent flex-grow focus:outline-none text-yellow-500" 
                    placeholder="Search users..."
                />
            </div>
            <!-- User List -->
            <div class="space-y-2">
                <div class="flex items-center gap-2 p-2 bg-gray-700 rounded-lg hover:bg-gray-600 cursor-pointer">
                    <img src="user1.png" class="w-10 h-10 rounded-full">
                    <p class="text-yellow-400">User One</p>
                </div>
                <div class="flex items-center gap-2 p-2 bg-gray-700 rounded-lg hover:bg-gray-600 cursor-pointer">
                    <img src="user2.png" class="w-10 h-10 rounded-full">
                    <p class="text-yellow-400">User Two</p>
                </div>
                <div class="flex items-center gap-2 p-2 bg-gray-700 rounded-lg hover:bg-gray-600 cursor-pointer">
                    <img src="user3.png" class="w-10 h-10 rounded-full">
                    <p class="text-yellow-400">User Three</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Current Chat User -->
            <div class="bg-gray-800 p-4 flex items-center gap-4 border-b border-gray-700">
                <img src="user_current.png" class="w-12 h-12 rounded-full">
                <div>
                    <p class="text-yellow-400 font-bold">Current Chat User</p>
                    <p class="text-gray-400 text-sm">Active now</p>
                </div>
            </div>

            <!-- Chat Messages -->
            <main class="flex-1 overflow-y-auto p-4">
                <div class="space-y-4">
                    <div class="bg-gray-800 p-3 rounded-lg max-w-xs">
                        <p class="text-yellow-400 font-semibold">User-1</p>
                        <p class="text-gray-300">Hey, can anyone explain the difference between Prim's and Kruskal's algorithms?</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg max-w-xs ml-auto">
                        <p class="text-gray-300">Is it for the App Dev project?</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg max-w-xs">
                        <p class="text-yellow-400 font-semibold">User-1</p>
                        <p class="text-gray-300">Yeah, teacher gave an assignment.</p>
                    </div>
                    <div class="bg-gray-800 p-3 rounded-lg max-w-xs ml-auto">
                        <p class="text-gray-300">I saw a very good post about that in a recent post in KNU.</p>
                    </div>
                </div>
            </main>

            <!-- Message Input -->
            <footer class="p-4 bg-gray-800 flex items-center gap-2">
                <input 
                    type="text" 
                    placeholder="Write a message..." 
                    class="flex-1 px-4 py-2 bg-gray-700 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button 
                    class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </footer>
        </div>
    </div>
</body>
</html>
