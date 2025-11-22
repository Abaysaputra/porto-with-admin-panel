<?php
/**
 * Sharing Content Get API
 * File: admin/php/api/sharing_get.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if (isset($_GET['id'])) {
    // Get single content
    $content = getSharingById($_GET['id']);
    
    if ($content) {
        echo json_encode(['success' => true, 'data' => $content]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Content not found']);
    }
} else {
    // Get all sharing content
    $content = getSharingContent();
    echo json_encode(['success' => true, 'data' => $content]);
}
?>
