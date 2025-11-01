<?php
include '../../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inbox_id'])) {
    $inbox_id = (int)$_POST['inbox_id'];    
    $stmt = $conn->prepare("UPDATE inbox SET is_read = 1 WHERE inbox_id = ?");
    $stmt->bind_param("i", $inbox_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
}
$conn->close();
?>