<?php
/**
 * Certificates Save API (Add/Update)
 * File: admin/php/api/certificates_save.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id            = $_POST['id'] ?? null;
$existingImage = $_POST['existing_image'] ?? '';

// Normalisasi issue_date ('' -> NULL)
$issueDateRaw = $_POST['issue_date'] ?? null;
$issueDate    = null;
if ($issueDateRaw !== null && $issueDateRaw !== '' && strtolower($issueDateRaw) !== 'null') {
    $issueDate = $issueDateRaw; // format yyyy-mm-dd dari input type="date"
}

// Siapkan data (tanpa image dulu)
$data = [
    'certificate_title'      => $_POST['certificate_title'] ?? '',
    'certificate_image'      => '', // akan diisi setelah upload
    'issuing_organization'   => $_POST['issuing_organization'] ?? '',
    'issue_date'             => $issueDate,
    'credential_id'          => $_POST['credential_id'] ?? '',
    'credential_url'         => $_POST['credential_url'] ?? '',
    'description'            => $_POST['description'] ?? '',
    'category'               => $_POST['category'] ?? 'course',
    'is_featured'            => isset($_POST['is_featured']) ? 1 : 0,
    'display_order'          => isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0
];

// ===============================
// HANDLE FILE UPLOAD (certificate_image)
// ===============================
if (isset($_FILES['certificate_image']) && is_uploaded_file($_FILES['certificate_image']['tmp_name'])) {
    $file = $_FILES['certificate_image'];

    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize    = 2 * 1024 * 1024; // 2MB

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WEBP'
        ]);
        exit;
    }

    if ($file['size'] > $maxSize) {
        echo json_encode([
            'success' => false,
            'message' => 'Image size too large. Max 2MB.'
        ]);
        exit;
    }

    // Folder upload dari root project
    $uploadDir = __DIR__ . '/../../../uploads/certificates/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    $fileName = 'cert_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $destPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload image.'
        ]);
        exit;
    }

    // Path untuk disimpan di database (relative)
    $data['certificate_image'] = 'uploads/certificates/' . $fileName;

    // Hapus file lama kalau update
    if (!empty($id) && !empty($existingImage)) {
        $oldPath = __DIR__ . '/../../../' . $existingImage;
        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }
} else {
    // Tidak upload baru → pakai image lama
    $data['certificate_image'] = $existingImage ?: '';
}

// Validasi field wajib
if (trim($data['certificate_title']) === '') {
    echo json_encode(['success' => false, 'message' => 'Certificate title is required']);
    exit;
}

// Add atau Update
if (!empty($id)) {
    $result = updateCertificate($id, $data);
} else {
    $result = addCertificate($data);
}

echo json_encode($result);
