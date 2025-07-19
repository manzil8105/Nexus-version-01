<?php
include("connection.php");

$id = $_GET["user_id"];
$sql = "SELECT * FROM User where user_id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>

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
    <p class="text-center text-sm mb-4">Provide New Name</p>

    <form action="pros.php" method="post">
      <div class="mb-4 hidden">
        <input
          type="text"
          placeholder="Name..."
          value="<?php echo $id; ?>"
          name="user_id"
          class="w-full px-4 py-2 bg-blue-900 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
      </div>

      <div class="mb-4">
        <input
          type="text"
          placeholder="Name..."
          value="<?php echo $row["name"]; ?>"
          name="name"
          class="w-full px-4 py-2 bg-blue-900 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
      </div>

      <div class="mb-4">
        <input
          type="password"
          placeholder="Password..."
          value=""
          name="password"
          class="w-full px-4 py-2 bg-blue-900 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
      </div>

      <div class="mb-4 max-w-xs text-center">
        <button
          type="submit"
          name="save_name"
          class="w-40 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-full font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Save
        </button>
    </form>

  </div>
  <footer class="absolute bottom-4 text-gray-400 text-sm">a product by Softcore</footer>
</body>

</html>