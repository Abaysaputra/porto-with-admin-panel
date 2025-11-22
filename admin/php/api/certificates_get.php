<?php
/**
 * Certificates Get API
 * File: admin/php/api/certificates_get.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if (isset($_GET['id'])) {
    // Get single certificate
    $certificate = getCertificateById($_GET['id']);
    
    if ($certificate) {
        echo json_encode(['success' => true, 'data' => $certificate]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Certificate not found']);
    }
} else {
    // Get all certificates
    $certificates = getCertificates();
    echo json_encode(['success' => true, 'data' => $certificates]);
}
?>
