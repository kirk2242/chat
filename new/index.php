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
    <title>Chat System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat Room</h2>
            <span>Welcome, <?= htmlspecialchars($username); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <div id="chat-box"></div>

        <div class="chat-input">
        <input type="text" id="message-input" placeholder="Type your message here...">
        <button id="send-btn">Send</button>

        </div>
    </div>
    <input type="hidden" id="room-id" value="1"> <!-- Ensure this is dynamically set -->

    <script src="chat.js"></script>
</body>
</html>
