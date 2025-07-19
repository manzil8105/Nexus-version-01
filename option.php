<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post Options Design</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 text-white h-screen flex items-center justify-center">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 w-full max-w-4xl">
    <!-- Left Column: User's Post Options and Admin's View -->
    <div class="space-y-8">
      <!-- User's Post Options -->
      <div>
        <h2 class="text-lg font-semibold mb-4">User's Post Options</h2>
        <div class="bg-gray-900 p-4 rounded-lg w-64">
          <button class="block w-full text-left text-yellow-400 font-bold mb-2">Edit Post</button>
          <button class="block w-full text-left text-red-500 font-bold">Delete Post</button>
        </div>
      </div>

      <!-- Users' Post Options from Admins View -->
      <div>
        <h2 class="text-lg font-semibold mb-4">Users' Post Options from Admins View</h2>
        <div class="bg-gray-900 p-4 rounded-lg w-64">
          <button class="block w-full text-left text-yellow-400 font-bold mb-2">Report Post</button>
          <button class="block w-full text-left text-red-500 font-bold">Delete Post</button>
        </div>
      </div>
    </div>

    <!-- Right Column: Others' Post Option from Users View -->
    <div>
      <h2 class="text-lg font-semibold mb-4">Others' Post Option from Users View</h2>
      <div class="bg-gray-900 p-4 rounded-lg w-64">
        <button class="block w-full text-left text-yellow-400 font-bold">Report Post</button>
      </div>
    </div>
  </div>
</body>
</html>
