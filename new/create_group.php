<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $group_name = trim($_POST['group_name']);
    if (empty($group_name)) {
        exit("Error: Group name cannot be empty.");
    }

    $stmt = $conn->prepare("INSERT INTO chat_rooms (name) VALUES (?)");
    $stmt->bind_param("s", $group_name);

    if ($stmt->execute()) {
        echo "Group created successfully! Group ID: " . $stmt->insert_id;
    } else {
        echo "Error: Could not create group.";
    }

    $stmt->close();
    $conn->close();
} else {
    exit("Error: Request must be POST");
}
