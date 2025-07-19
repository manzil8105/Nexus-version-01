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
  <title>Another User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-300">
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
  <main class="p-6">
    
    <div class="flex items-start bg-gray-800 p-4 rounded-lg">
      <div class="flex justify-between w-full">
        <div class="text-white p-4 rounded-lg flex items-center space-x-4">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQm3RFDZM21teuCMFYx_AROjt-AzUwDBROFww&s"
            alt="Profile Picture" class="h-28 rounded-md object-cover" />
          <div class="bg-gray-900 rounded-lg px-3 py-2">
            <h2 class="text-lg font-semibold">Avik Saha</h2>
            <p class="text-gray-400">m2</p>
            <a href="mailto:avikcse72@gmail.com" class="text-blue-400 hover:underline">avikcse72@gmail.com</a>
            <p class="text-red-500">
              &lt;explorer&gt; <span class="text-green-500">[83]</span>
            </p>
            
          </div>
          <div class="ml-auto grid gap-y-4 ">
            <button class="flex items-center space-x-1 text-yellow-400 hover:text-yellow-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm12 2H7v14h10V5zm-5 4a1 1 0 011-1h2a1 1 0 010 2h-2a1 1 0 01-1-1zm-2 8a1 1 0 110-2h6a1 1 0 010 2H10zm-1-5H7a1 1 0 110-2h2a1 1 0 010 2z"/>
              </svg>
              <span>Bookmarks</span>
            </button>
        
            <button class="flex items-center space-x-1 text-yellow-400 hover:text-yellow-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4 3h16a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2zm14 2H6v14h12V5zm-6 11a1 1 0 11-2 0v-4a1 1 0 112 0v4zm0-7a1 1 0 110-2h4a1 1 0 010 2h-4z"/>
              </svg>
              <span>Posts</span>
            </button>
        
            <button class="flex items-center space-x-1 text-green-400 hover:text-green-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
              </svg>
              <span>Answers</span>
            </button>
          </div>
        </div>

        <!-- Option Button with Pop-up -->
        <div class="relative">
          <button >
            <img class="h-16" src="settings.png" alt="option">
          </button>
          <!-- Pop-up Window -->
          <div id="popupWindow" class="hidden absolute bg-gray-900 text-white p-4 rounded-lg shadow-lg w-48"
            style="top: 100%; left: -150px;">
            <button class="block text-yellow-400 font-bold text-left w-full py-2 hover:text-yellow-300">
              Report post
            </button>
            
          </div>
        </div>
      </div>
      
    </div>

    <div class="mt-6">
      <div class="bg-gray-800 rounded-lg p-4 mb-6 shadow-md border-2 border-yellow-500">
        <div class="flex justify-between">
          <div class="flex items-center gap-2 mb-2">
            <img src="profile.png" alt="User" class="h-10 w-10 rounded-full">
            <div>
              <h3 class="font-semibold">Avik Saha</h3>
              <p class="text-sm text-gray-400">&lt;Explorer&gt;</p>
            </div>
          </div>
          <button onclick="togglePopup()" class="text-gray-900">
            <img class="h-12" src="option.png" alt="filter">
          </button>
        </div>
        <h2 class="text-lg font-bold">How does the A* algorithm find the shortest path in a graph?</h2>
        <p class="text-gray-300 mt-2 bg-gray-900 p-4">
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur porro eaque tempore tenetur eveniet
          cupiditate velit cum, minus ullam esse corrupti libero quia nisi voluptatibus soluta est dolore numquam
          voluptate molestiae.quaerat ipsa laborum facere iure, totam nesciunt ut nulla delectus, facilis nam. Eius 
          eos similique minus nisi illum mollitia rem qui porro blanditiis nesciunt quisquam magnam labore dolorem 
          quae aliquam, eveniet in perferendis possimus quis quod unde praesentium laudantium ratione? Sit nostrum, 
          fuga voluptas repellat culpa eaque, distinctio assumenda molestiae nulla ipsam cum facere quas doloribus
           non! Iusto quis ut minus quidem nihil assumenda eaque ea, quae sapiente inventore libero dolorem animi 
           illum quod magnam nostrum natus voluptas. Ut veniam nemo minus repudiandae non, iste hic a beatae numquam
            impedit, iure consectetur dolore, nisi inventore illo! In sed expedita voluptates rerum eveniet dolorum 
            voluptatem eligendi harum placeat veniam a debitis officia quia ipsam tempore, enim consequuntur voluptate 
            sunt. Quam sunt harum aspernatur ut eius ea illum vero rem distinctio earum! Exercitationem, consequuntur
             sed ipsa ducimus delectus minus autem obcaecati quos eveniet incidunt, officiis blanditiis, reiciendis
             amet consequatur a. Tempora id quibusdam quo odio delectus possimus ut ab autem, sequi voluptatum, vero
              molestiae. Iusto vitae eum expedita quia 
          <a href="fullpostview.html" class="text-yellow-400">See More</a>
        </p>
        <div class="flex items-center justify-between text-yellow-400 mt-4">
          <div class="flex space-x-6 items-center">
            <button class="flex items-center space-x-1 hover:text-red-500">
              <span>❤️</span>
              <span>30</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-gray-500">
              <span>👎</span>
              <span>10</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-yellow-300">
              <span>📑</span>
              <span>15</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-blue-400">
              <span>💬</span>
              <span>42</span>
            </button>
            <button class="flex items-center space-x-1 hover:text-green-400">
              <span>📤</span>
              <span>3</span>
            </button>
          </div>
          <button class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-md">
            AI
          </button>
        </div>
      </div>
    </div>
  </main>

  <script>
    function togglePopup() {
      const popup = document.getElementById("popupWindow");
      popup.classList.toggle("hidden");
    }
  </script>
</body>

</html>
