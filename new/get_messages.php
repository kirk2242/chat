<?php
include 'db.php';

$room_id = intval($_GET['room_id'] ?? 1); // Default to room ID 1 if not provided
$stmt = $conn->prepare("SELECT messages.id, users.id AS user_id, users.username, messages.message, messages.created_at AS timestamp FROM messages JOIN users ON messages.user_id = users.id WHERE messages.room_id = ? ORDER BY messages.created_at ASC");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);

$stmt->close();
$conn->close();
?>
