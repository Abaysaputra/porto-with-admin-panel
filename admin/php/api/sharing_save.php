<?php
/**
 * Sharing Content Save API (Add/Update)
 * File: admin/php/api/sharing_save.php
 */

header('Content-Type: application/json');
require_once '../../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id            = $_POST['id'] ?? null;
$existingImage = $_POST['existing_image'] ?? '';

// === Handle tanggal ===
$publishedDate = $_POST['published_date'] ?? '';

if (empty($publishedDate)) {
    $publishedDate = date('Y-m-d');
} else {
    // kalau user isi 2025 saja → 2025-01-01
    if (strlen($publishedDate) === 4 && ctype_digit($publishedDate)) {
        $publishedDate .= '-01-01';
    }

    $dateObj = DateTime::createFromFormat('Y-m-d', $publishedDate);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $publishedDate) {
        echo json_encode(['success' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD']);
        exit;
    }
}

// Siapkan data dasar (tanpa image dulu)
$data = [
    'content_title'       => $_POST['content_title'] ?? '',
    'content_image'       => '', // akan diisi setelah upload
    'content_description' => $_POST['content_description'] ?? '',
    'category'            => $_POST['category'] ?? 'other',
    'read_time'           => $_POST['read_time'] ?? '2 min read',
    'published_date'      => $publishedDate,
    'display_order'       => isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0,
    'status'              => $_POST['status'] ?? 'published'
];

// === HANDLE FILE UPLOAD (content_image) ===
if (isset($_FILES['content_image']) && is_uploaded_file($_FILES['content_image']['tmp_name'])) {
    $file = $_FILES['content_image'];

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

    $uploadDir = __DIR__ . '/../../../uploads/sharing/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    $fileName = 'sharing_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $destPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload image.'
        ]);
        exit;
    }

    // path relative untuk disimpan di DB
    $data['content_image'] = 'uploads/sharing/' . $fileName;

    // hapus gambar lama kalau update
    if (!empty($id) && !empty($existingImage)) {
        $oldPath = __DIR__ . '/../../../' . $existingImage;
        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }
} else {
    // tidak upload baru → pakai gambar lama
    $data['content_image'] = $existingImage ?: '';
}

// Validasi wajib
if (trim($data['content_title']) === '') {
    echo json_encode(['success' => false, 'message' => 'Content title is required']);
    exit;
}

// Add / Update
if (!empty($id)) {
    $result = updateSharingContent($id, $data);
} else {
    $result = addSharingContent($data);
}

echo json_encode($result);
