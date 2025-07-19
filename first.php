<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 flex justify-center items-center h-screen">
    <div class="w-full max-w-xs mt-20 text-center">

        <h1 class="text-yellow-500 text-3xl font-bold mb-8">&lt;Nexus&gt;</h1>

        <form action="login.php" method="post">
            <input
                type="email"
                name="email"
                placeholder="Email....."
                class="w-full px-4 py-2 mb-4 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input
                type="password"
                name="password"
                placeholder="Password..."
                class="w-full px-4 py-2 mb-6 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button
                type="submit"
                name="login"
                class="w-40 bg-green-700 text-white font-bold py-2 rounded-full hover:bg-green-500 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-300 ">
                Log In
            </button>
            <a href="signup.php">

                <button

                    type="button"
                    class="w-40 bg-yellow-400 text-white font-bold py-2 rounded-full hover:bg-yellow-400 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Sign Up?
                </button>
            </a>
            <!-- <a href="passwordreset.php"> <button
                    type="button"
                    class="w-40 bg-red-600 text-white font-bold py-2 rounded-full hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Forgot Password?
                </button>
            </a> -->
        </form>
        <footer class=" text-center mt-80 bottom-4  text-gray-400 text-sm "> a product by Softcore</footer>
    </div>
</body>

</html>