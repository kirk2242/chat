<?php
include 'db.php';

$result = $conn->query("SELECT users.username, messages.message FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at ASC");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
echo json_encode($messages);
?>
