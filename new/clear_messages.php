<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Delete all messages in the chat box
    $stmt = $conn->prepare("DELETE FROM messages");

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: Could not clear messages.";
    }

    $stmt->close();
    $conn->close();
} else {
    exit("Error: Request must be POST");
}
