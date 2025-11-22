<?php
/**
 * Profile Get API
 * File: admin/php/api/profile_get.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

$profile = getProfile();

if ($profile) {
    echo json_encode(['success' => true, 'data' => $profile]);
} else {
    echo json_encode(['success' => false, 'message' => 'Profile not found']);
}
?>
