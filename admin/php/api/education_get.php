<?php
header('Content-Type: application/json');
require_once '../../../includes/functions.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid education ID']);
    exit;
}

$edu = getEducationById($id);

if (!$edu) {
    echo json_encode(['success' => false, 'message' => 'Education not found']);
    exit;
}

echo json_encode(['success' => true, 'data' => $edu]);
