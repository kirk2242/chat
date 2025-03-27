<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message_id = intval($_POST['message_id']);
    $user_id = $_SESSION['user_id'];

    // Ensure the message belongs to the user
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $message_id, $user_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "Error: Could not delete message.";
    }

    $stmt->close();
    $conn->close();
} else {
    exit("Error: Request must be POST");
}
