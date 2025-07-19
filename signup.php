<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Nexus - Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 flex justify-center items-center h-screen">
    <div class="w-full max-w-xs text-center">
        <h1 class="text-yellow-500 text-3xl font-bold mb-8">&lt;Knowledge Nexus&gt;</h1>

         <form action ="pros.php" method="post">
            <input
                type="text"
                name="name"
                placeholder="Name..."
                class="w-full px-4 py-2 mb-4 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <input
                type="email"
                name="email"
                placeholder="Email....."
                class="w-full px-4 py-2 mb-4 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <input
                type="password"
                name="pass"
                placeholder="Password..."
                class="w-full px-4 py-2 mb-4 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <input
                type="password"
                name="conpass"
                placeholder="Confirm Password..."
                class="w-full px-4 py-2 mb-6 bg-blue-900 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            >

    

            <input
                type="hidden"
                value="regular"
                name="role"
                
            >

            <!-- <input type="submit" 
            name="createID" 
            value="signup"
            class="w-40 bg-yellow-500 text-white font-bold py-2 rounded-full hover:bg-yellow-400"
            > -->
            <button
                type="submit"
                name="createID"
                value="sign up"
                class="w-40 bg-yellow-500 text-white font-bold py-2 rounded-full hover:bg-yellow-400"
            >
                Sign Up
            </button>
        </form>
        <footer class=" text-center absolute bottom-4  text-gray-400 text-sm " > a product by Softcore</footer>
    </div>
</body>
</html>