<?php
/**
 * Projects Save API - FINAL CLEAN VERSION
 * File: admin/php/api/projects_save.php
 */

// Start output buffering FIRST (prevent any output before header)
ob_start();

// Start session if needed
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

error_reporting(0);
ini_set('display_errors', 0);

// Function to send JSON response
function sendJSON($data) {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    ob_end_flush();
    exit;
}

try {
    // Include functions
    $functionsPath = __DIR__ . '/../../../includes/functions.php';
    
    if (!file_exists($functionsPath)) {
        sendJSON(['success' => false, 'message' => 'Functions file not found: ' . $functionsPath]);
    }
    
    require_once $functionsPath;
    
    // Check POST method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendJSON(['success' => false, 'message' => 'Method not allowed. Expected POST, got ' . $_SERVER['REQUEST_METHOD']]);
    }
    
    // Get ID (empty string or null for new, integer for update)
    $id = null;
    if (isset($_POST['id']) && $_POST['id'] !== '' && $_POST['id'] !== 'null') {
        $id = intval($_POST['id']);
            }
            
            // Build data array with defaults
        // Build data array with defaults (tanpa project_image dulu)
        $data = [
            'project_name' => isset($_POST['project_name']) ? trim($_POST['project_name']) : '',
            'project_image' => '', // akan diisi setelah proses upload
            'short_description' => isset($_POST['short_description']) ? trim($_POST['short_description']) : '',
            'full_description' => isset($_POST['full_description']) ? trim($_POST['full_description']) : '',
            'technologies' => isset($_POST['technologies']) ? trim($_POST['technologies']) : '',
            'project_url' => isset($_POST['project_url']) ? trim($_POST['project_url']) : '',
            'start_date' => null,
            'end_date' => null,
            'category' => isset($_POST['category']) ? $_POST['category'] : 'web',
            'is_featured' => (isset($_POST['is_featured']) && $_POST['is_featured']) ? 1 : 0,
            'display_order' => isset($_POST['display_order']) ? intval($_POST['display_order']) : 0,
            'status' => isset($_POST['status']) ? $_POST['status'] : 'completed'
        ];

            
        // Handle dates - CAREFUL with empty strings
        if (isset($_POST['start_date']) && $_POST['start_date'] !== '' && $_POST['start_date'] !== 'null') {
            $data['start_date'] = fixDateFormat($_POST['start_date']);
        }

        if (isset($_POST['end_date']) && $_POST['end_date'] !== '' && $_POST['end_date'] !== 'null') {
            $data['end_date'] = fixDateFormat($_POST['end_date']);
        }

    // ===============================
// HANDLE FILE UPLOAD (project_image)
// ===============================
$existingImage = isset($_POST['existing_image']) ? trim($_POST['existing_image']) : '';

if (isset($_FILES['project_image']) && is_uploaded_file($_FILES['project_image']['tmp_name'])) {
    $file = $_FILES['project_image'];

    // Validasi dasar
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        sendJSON([
            'success' => false,
            'message' => 'Invalid image format. Allowed: JPG, PNG, GIF, WEBP'
        ]);
    }

    if ($file['size'] > $maxSize) {
        sendJSON([
            'success' => false,
            'message' => 'Image size too large. Max 2MB.'
        ]);
    }

    // Folder upload (relative to project root)
    $uploadDir = __DIR__ . '/../../../uploads/projects/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    // Nama file unik
    $fileName = 'project_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $destPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        sendJSON([
            'success' => false,
            'message' => 'Failed to upload image.'
        ]);
    }

    // Path yang disimpan di database (relative, seperti sebelumnya)
    $data['project_image'] = 'uploads/projects/' . $fileName;

    // OPTIONAL: hapus file lama kalau update dan file lama ada
    if ($id && $existingImage) {
        $oldPath = __DIR__ . '/../../../' . $existingImage;
        if (is_file($oldPath)) {
            @unlink($oldPath);
        }
    }
} else {
    // Tidak ada upload baru → pakai existing image kalau ada
    $data['project_image'] = $existingImage ?: '';
}

    // Validate required fields
    if (empty($data['project_name'])) {
        sendJSON(['success' => false, 'message' => 'Project name is required']);
    }
    
    if (empty($data['short_description'])) {
        sendJSON(['success' => false, 'message' => 'Short description is required']);
    }
    
    // Execute save operation
    if ($id) {
        // Update existing project
        $result = updateProject($id, $data);
    } else {
        // Add new project
        $result = addProject($data);
    }
    
    // Send response
    sendJSON($result);
    
} catch (mysqli_sql_exception $e) {
    error_log("Projects Save - Database Error: " . $e->getMessage());
    sendJSON([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    
} catch (Exception $e) {
    error_log("Projects Save - Error: " . $e->getMessage());
    error_log("Projects Save - Trace: " . $e->getTraceAsString());
    sendJSON([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
