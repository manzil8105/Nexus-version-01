<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Knowledge Nexus</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex flex-col justify-center items-center min-h-screen">

  <h1 class="text-yellow-400 text-4xl font-bold mb-8">&lt;Knowledge Nexus&gt;</h1>

  <div class="bg-gray-800 p-6 rounded-lg shadow-md w-80">
    <p class="text-center text-sm mb-4">Please Provide The OTP sent to your email</p>

    <form>
      <div class="mb-4">
        <input 
          type="text" 
          placeholder="OTP..." 
          class="w-full px-4 py-2 bg-blue-900 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
      </div>
      <div class="text-right mb-4">
        <a href="#" class="text-yellow-400 text-sm hover:underline">Resend OTP</a>
      </div>
      <div class="mb-4 max-w-xs text-center"> 
        <button 
        type="submit" >
        <a href="newpassword.php" class="px-10 py-2 mt-8 w-40 bg-blue-500 justify-center hover:bg-blue-600 text-white py-2 rounded-full font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ">Next</a>
      </button>
    </a>
    </form>
  </div>

  <!-- Footer -->
  <footer class="absolute bottom-4 text-gray-400 text-sm">a product by Softcore</footer>
</body>
</html>
