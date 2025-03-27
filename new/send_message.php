<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $room_id = intval($_POST['room_id']); // Ensure this value is sent from the frontend
    $message = trim($_POST['message']);

    if (empty($message)) {
        exit("Error: Message cannot be empty.");
    }

    // **Check if room exists**
    $room_check = $conn->prepare("SELECT id FROM chat_rooms WHERE id = ?");
    $room_check->bind_param("i", $room_id);
    $room_check->execute();
    $room_check->store_result();

    if ($room_check->num_rows === 0) {
        exit("Error: Chat room does not exist.");
    }
    $room_check->close();

    // **Insert the message if the room exists**
    $stmt = $conn->prepare("INSERT INTO messages (user_id, room_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $room_id, $message);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: Could not send message.";
    }

    $stmt->close();
    $conn->close();
} else {
    exit("Error: Request must be POST");
}
?>
