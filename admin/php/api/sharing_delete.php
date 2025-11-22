<?php
/**
 * Sharing Content Delete API
 * File: admin/php/api/sharing_delete.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Content ID is required']);
        exit;
    }
    
    $result = deleteSharingContent($id);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
