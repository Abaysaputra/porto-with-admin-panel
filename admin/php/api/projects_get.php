<?php
/**
 * Projects Get API
 * File: admin/php/api/projects_get.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if (isset($_GET['id'])) {
    // Get single project
    $project = getProjectById($_GET['id']);
    
    if ($project) {
        echo json_encode(['success' => true, 'data' => $project]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Project not found']);
    }
} else {
    // Get all projects
    $projects = getProjects();
    echo json_encode(['success' => true, 'data' => $projects]);
}
?>
