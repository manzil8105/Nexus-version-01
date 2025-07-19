<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: first.php");
    exit;
}

include("connection.php");


// Handle message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    $user_id = $_SESSION['user_id'];

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO Message (message, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $message, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all messages
$messages = [];
$result = $conn->query("SELECT Message.message, User.user_id, User.name FROM Message JOIN User ON Message.user_id = User.user_id ORDER BY Message.id ASC");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex items-center justify-between shadow-md">
        <div>
            <a href="hompage.php"><img src="home.png" alt="Home" class="h-8"></a>
        </div>
        <div class="flex-1 mx-8">
            <div class="bg-gray-700 border border-yellow-500 rounded-full flex items-center px-3 py-1">
                <img src="search.png" alt="Search" class="w-6 h-6 mr-2">
                <form action="homepage.php" method="GET" class="w-full">
                    <input type="text" name="search" placeholder="Search Tags" value=""
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

    <div class="flex-1 flex flex-col">
        <!-- Main Chat Section -->
        <main class="h-[600px] overflow-y-auto p-4">
            <div style="margin: 20px; border: 1px solid #ccc; padding: 15px;">
  <h3>📨 Chat with Another User</h3>
  <label for="userList">Select user to message:</label>
  <select id="userList" style="margin-bottom: 10px; background:rgb(56, 73, 110);"></select>

  <div id="chatBox" style="border:1px solid #aaa; height:200px; overflow-y:scroll; padding: 10px; background: #111827;"></div>

  <input type="text" id="msgInput" placeholder="Type a message" style="width: 70%; background: #111827;" />
  <button onclick="sendMessage()">Send</button>
</div>
        </main>

       
    </div>

<!-- Messaging Script Starts Here -->
<script>
let currentReceiver = null;

document.addEventListener("DOMContentLoaded", () => {
    fetchUsers();
});

function fetchUsers() {
    fetch('get_users.php')
        .then(res => res.json())
        .then(users => {
            const list = document.getElementById('userList');
            list.innerHTML = "";
            users.forEach(user => {
                const opt = document.createElement('option');
                opt.value = user.user_id;
                opt.innerText = user.name;
                list.appendChild(opt);
            });

            currentReceiver = list.value;
            loadMessages();

            list.addEventListener('change', () => {
                currentReceiver = list.value;
                loadMessages();
            });
        });
}

function loadMessages() {
    fetch('messages.php?receiver_id=' + currentReceiver)
        .then(res => res.json())
        .then(messages => {
            const chatBox = document.getElementById('chatBox');
            chatBox.innerHTML = '';
            messages.forEach(msg => {
                const div = document.createElement('div');
                div.textContent = (msg.sender_id == <?= $_SESSION['user_id'] ?> ? 'You' : 'Them') + ": " + msg.message;
                chatBox.appendChild(div);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

function sendMessage() {
    const message = document.getElementById('msgInput').value;
    fetch('messages.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `receiver_id=${currentReceiver}&message=${encodeURIComponent(message)}`
    }).then(() => {
        document.getElementById('msgInput').value = '';
        loadMessages();
    });
}
</script>
<!--  Messaging Script Ends -->


</body>

</html>