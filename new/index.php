<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
    let currentUserId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
    console.log("Current User ID:", currentUserId); // Debugging
</script>


    <title>Chat System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="chat-container">
<div class="chat-header">
    <h3>Chat</h3>
    <div>
        <button id="logout-btn">Logout</button>
        <button id="clear-all-btn" style="margin-left: 10px;">Clear All Messages</button>
    </div>
</div>

<div class="welcome-message">
    <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
</div>

    <div class="chat-box" id="chat-box">
        <!-- Messages will be loaded here -->
    </div>

    <div class="message-input-container">
        <input type="text" id="message-input" placeholder="Send a Chat..." autocomplete="off">
        <button id="send-btn">
            <img src="" alt="Send">
        </button>
    </div>
</div>

    <input type="hidden" id="room-id" value="1"> <!-- Ensure this is dynamically set -->

    <script>
    document.getElementById("create-group-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const groupName = document.getElementById("group-name").value;
        fetch("create_group.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "group_name=" + encodeURIComponent(groupName)
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error("Error creating group:", error));
    });

    document.getElementById("join-group-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const groupId = document.getElementById("group-id").value;
        document.getElementById("room-id").value = groupId;
        alert("Joined group " + groupId);
    });
</script>

    <script src="chat.js"></script>
</body>
</html>
