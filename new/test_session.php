<?php
session_start();
echo "User ID from session: " . ($_SESSION['user_id'] ?? 'Not Set');
?>
