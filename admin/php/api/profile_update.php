<?php
/**
 * Profile Update API
 * File: admin/php/api/profile_update.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'] ?? '';
    $value = $_POST['value'] ?? '';
    
    if (empty($field) || empty($value)) {
        echo json_encode(['success' => false, 'message' => 'Field and value required']);
        exit;
    }
    
    $result = updateProfileField($field, $value);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
