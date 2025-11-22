<?php
/**
 * Helper Functions - UPDATED
 * File: includes/functions.php
 */

require_once __DIR__ . '/../config/database.php';

function fixDateFormat($date) {
    // Jika kosong, return hari ini
    if (empty($date) || $date === null) {
        return date('Y-m-d');
    }
    
    // Trim whitespace
    $date = trim($date);
    
    // Jika hanya tahun (4 digit angka), tambahkan -01-01
    if (strlen($date) === 4 && is_numeric($date)) {
        return $date . '-01-01';
    }
    
    // Jika sudah format Y-m-d, validasi dan return
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateObj && $dateObj->format('Y-m-d') === $date) {
        return $date;
    }
    
    // Jika format lain, coba parse dengan strtotime
    $timestamp = strtotime($date);
    if ($timestamp !== false) {
        return date('Y-m-d', $timestamp);
    }
    
    // Fallback: return hari ini
    return date('Y-m-d');
}
/**
 * Get profile data
 */
function getProfile() {
    $conn = getDB();
    $sql = "SELECT * FROM profile WHERE id = 1 LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

/**
 * Get all education data ordered by display_order
 */
/**
 * Ambil list education
 */
function getEducation($limit = null) {
    $conn = getDB();

    $sql = "SELECT * FROM education ORDER BY display_order ASC, period_end DESC, id DESC";

    if ($limit !== null) {
        $stmt = $conn->prepare($sql . " LIMIT ?");
        $stmt->bind_param("i", $limit);
    } else {
        $stmt = $conn->prepare($sql);
    }

    if (!$stmt) {
        return [];
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();

    return $rows;
}

/**
 * Ambil 1 education by ID
 */
function getEducationById($id) {
    $conn = getDB();
    $stmt = $conn->prepare("SELECT * FROM education WHERE id = ?");
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

/**
 * Tambah education
 */
function addEducation($data) {
    $conn = getDB();

    $stmt = $conn->prepare("
        INSERT INTO education
        (period_start, period_end, degree, institution, description, display_order)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssi",
        $data['period_start'],
        $data['period_end'],
        $data['degree'],
        $data['institution'],
        $data['description'],
        $data['display_order']
    );

    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Education added successfully',
            'id'      => $conn->insert_id
        ];
    }

    return ['success' => false, 'message' => 'Failed to add education: ' . $stmt->error];
}

/**
 * Update education
 */
function updateEducation($id, $data) {
    $conn = getDB();

    $stmt = $conn->prepare("
        UPDATE education SET
            period_start  = ?,
            period_end    = ?,
            degree        = ?,
            institution   = ?,
            description   = ?,
            display_order = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        return ['success' => false, 'message' => 'Prepare failed: ' . $conn->error];
    }

    // 🔧 PERBAIKAN DI SINI: "sssssii" (5 string, 2 integer)
    $stmt->bind_param(
        "sssssii",
        $data['period_start'],   // s
        $data['period_end'],     // s
        $data['degree'],         // s
        $data['institution'],    // s
        $data['description'],    // s
        $data['display_order'],  // i
        $id                      // i
    );

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Education updated successfully'];
    }

    return ['success' => false, 'message' => 'Failed to update education: ' . $stmt->error];
}


/**
 * Delete education
 */
function deleteEducation($id) {
    $conn = getDB();
    $stmt = $conn->prepare("DELETE FROM education WHERE id = ?");
    if (!$stmt) {
        return ['success' => false, 'message' => 'Prepare failed: ' . $conn->error];
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Education deleted successfully'];
    }

    return ['success' => false, 'message' => 'Failed to delete education: ' . $stmt->error];
}

/**
 * Update profile field
 */
function updateProfileField($field, $value) {
    $conn = getDB();
    
    // Whitelist allowed fields
    $allowed_fields = [
        'full_name', 'title', 'bio_short', 'bio_long', 
        'email', 'phone', 'location', 'profile_image',
        'instagram', 'linkedin', 'github', 'twitter', 
        'facebook', 'medium', 'threads'
    ];
    
    if (!in_array($field, $allowed_fields)) {
        return ['success' => false, 'message' => 'Invalid field'];
    }
    
    $stmt = $conn->prepare("UPDATE profile SET $field = ?, updated_at = NOW() WHERE id = 1");
    $stmt->bind_param("s", $value);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Data updated successfully'];
    }
    
    return ['success' => false, 'message' => 'Update failed: ' . $conn->error];
}

/**
 * Sanitize output
 */
function h($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Format phone number
 */
function formatPhone($phone) {
    return preg_replace('/[^0-9+]/', '', $phone);
}

/**
 * Get site settings
 */
function getSiteSetting($key) {
    $conn = getDB();
    $stmt = $conn->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['setting_value'];
    }
    
    return null;
}

function getProjects($limit = null, $featured_only = false) {
    $conn = getDB();
    
    $sql = "SELECT * FROM projects WHERE 1=1";
    
    if ($featured_only) {
        $sql .= " AND is_featured = 1";
    }
    
    $sql .= " ORDER BY display_order ASC, created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $result = $conn->query($sql);
    
    $projects = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
    }
    
    return $projects;
}

/**
 * Get single project by ID
 */
function getProjectById($id) {
    $conn = getDB();
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

/**
 * Add new project - SIMPLIFIED
 */
function addProject($data) {
    $conn = getDB();
    
    try {
        // Prepare SQL
        $sql = "INSERT INTO projects (
            project_name, 
            project_image, 
            short_description, 
            full_description, 
            technologies, 
            project_url, 
            start_date, 
            end_date, 
            category, 
            is_featured, 
            display_order, 
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        // Bind params
        $stmt->bind_param("sssssssssiis",
            $data['project_name'],
            $data['project_image'],
            $data['short_description'],
            $data['full_description'],
            $data['technologies'],
            $data['project_url'],
            $data['start_date'],
            $data['end_date'],
            $data['category'],
            $data['is_featured'],
            $data['display_order'],
            $data['status']
        );
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Project added successfully',
                'id' => $conn->insert_id
            ];
        }
        
        throw new Exception("Execute failed: " . $stmt->error);
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Failed to add project: ' . $e->getMessage()
        ];
    }
}

/**
 * Update project - SIMPLIFIED
 */
function updateProject($id, $data) {
    $conn = getDB();
    
    try {
        $sql = "UPDATE projects SET 
            project_name = ?, 
            project_image = ?, 
            short_description = ?, 
            full_description = ?, 
            technologies = ?, 
            project_url = ?, 
            start_date = ?, 
            end_date = ?, 
            category = ?, 
            is_featured = ?, 
            display_order = ?, 
            status = ? 
            WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // 9 string (s), 2 integer (i), 1 string (s), 1 integer (i)
        // project_name, project_image, short_description, full_description,
        // technologies, project_url, start_date, end_date, category,
        // is_featured, display_order, status, id
        $ok = $stmt->bind_param(
            "sssssssssiisi",
            $data['project_name'],   // s
            $data['project_image'],  // s
            $data['short_description'], // s
            $data['full_description'],  // s
            $data['technologies'],   // s
            $data['project_url'],    // s
            $data['start_date'],     // s
            $data['end_date'],       // s
            $data['category'],       // s
            $data['is_featured'],    // i
            $data['display_order'],  // i
            $data['status'],         // s
            $id                      // i
        );

        if (!$ok) {
            throw new Exception("Bind param failed: " . $stmt->error);
        }
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Project updated successfully'
            ];
        }
        
        throw new Exception("Execute failed: " . $stmt->error);
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Failed to update project: ' . $e->getMessage()
        ];
    }
}



/**
 * Delete project
 */
function deleteProject($id) {
    $conn = getDB();
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Project deleted successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to delete project: ' . $conn->error];
}

/**
 * Calculate project duration
 */
function calculateDuration($start_date, $end_date) {
    if (!$start_date || !$end_date) return 'N/A';
    
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = $start->diff($end);
    
    if ($interval->y > 0) {
        return $interval->y . ' Year' . ($interval->y > 1 ? 's' : '');
    } elseif ($interval->m > 0) {
        return $interval->m . ' Month' . ($interval->m > 1 ? 's' : '');
    } elseif ($interval->d > 7) {
        $weeks = floor($interval->d / 7);
        return $weeks . ' Week' . ($weeks > 1 ? 's' : '');
    } else {
        return $interval->d . ' Day' . ($interval->d > 1 ? 's' : '');
    }
}
function getCertificates($limit = null, $featured_only = false) {
    $conn = getDB();
    
    $sql = "SELECT * FROM certificates WHERE 1=1";
    
    if ($featured_only) {
        $sql .= " AND is_featured = 1";
    }
    
    $sql .= " ORDER BY issue_date DESC, display_order ASC";
    
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $result = $conn->query($sql);
    
    $certificates = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $certificates[] = $row;
        }
    }
    
    return $certificates;
}

/**
 * Get single certificate by ID
 */
function getCertificateById($id) {
    $conn = getDB();
    $stmt = $conn->prepare("SELECT * FROM certificates WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

/**
 * Add new certificate
 */
function addCertificate($data) {
    $conn = getDB();
    
    $stmt = $conn->prepare("INSERT INTO certificates (certificate_title, certificate_image, issuing_organization, issue_date, credential_id, credential_url, description, category, is_featured, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssssii", 
        $data['certificate_title'], 
        $data['certificate_image'], 
        $data['issuing_organization'], 
        $data['issue_date'], 
        $data['credential_id'], 
        $data['credential_url'], 
        $data['description'], 
        $data['category'], 
        $data['is_featured'], 
        $data['display_order']
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Certificate added successfully', 'id' => $conn->insert_id];
    }
    
    return ['success' => false, 'message' => 'Failed to add certificate: ' . $conn->error];
}

/**
 * Update certificate
 */
function updateCertificate($id, $data) {
    $conn = getDB();
    
    $stmt = $conn->prepare("UPDATE certificates SET certificate_title = ?, certificate_image = ?, issuing_organization = ?, issue_date = ?, credential_id = ?, credential_url = ?, description = ?, category = ?, is_featured = ?, display_order = ? WHERE id = ?");
    
    $stmt->bind_param("ssssssssiii", 
        $data['certificate_title'], 
        $data['certificate_image'], 
        $data['issuing_organization'], 
        $data['issue_date'], 
        $data['credential_id'], 
        $data['credential_url'], 
        $data['description'], 
        $data['category'], 
        $data['is_featured'], 
        $data['display_order'],
        $id
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Certificate updated successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to update certificate: ' . $conn->error];
}

/**
 * Delete certificate
 */
function deleteCertificate($id) {
    $conn = getDB();
    $stmt = $conn->prepare("DELETE FROM certificates WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Certificate deleted successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to delete certificate: ' . $conn->error];
}

/**
 * Format date to readable format
 */
function formatCertificateDate($date) {
    if (!$date) return 'N/A';
    $timestamp = strtotime($date);
    return date('d F Y', $timestamp);
}

function getSharingContent($limit = null, $category = null) {
    $conn = getDB();
    
    $sql = "SELECT * FROM sharing_content WHERE 1=1";
    
    if ($category) {
        $sql .= " AND category = '" . $conn->real_escape_string($category) . "'";
    }
    
    $sql .= " ORDER BY published_date DESC, display_order ASC";
    
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $result = $conn->query($sql);
    
    $content = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $content[] = $row;
        }
    }
    
    return $content;
}

/**
 * Get single sharing content by ID
 */
function getSharingById($id) {
    $conn = getDB();
    $stmt = $conn->prepare("SELECT * FROM sharing_content WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

/**
 * Add new sharing content
 */
function addSharingContent($data) {
    $conn = getDB();
    
    $stmt = $conn->prepare(
        "INSERT INTO sharing_content 
        (content_title, content_image, content_description, category, read_time, published_date, display_order, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    // content_title (s), content_image (s), content_description (s),
    // category (s), read_time (s), published_date (s),
    // display_order (i), status (s)
    $stmt->bind_param(
        "ssssssis",
        $data['content_title'], 
        $data['content_image'], 
        $data['content_description'], 
        $data['category'], 
        $data['read_time'], 
        $data['published_date'], 
        $data['display_order'],
        $data['status']
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Content added successfully', 'id' => $conn->insert_id];
    }
    
    return ['success' => false, 'message' => 'Failed to add content: ' . $conn->error];
}

function updateSharingContent($id, $data) {
    $conn = getDB();

    if (isset($data['published_date'])) {
        $data['published_date'] = fixDateFormat($data['published_date']);
    }
    
    $stmt = $conn->prepare(
        "UPDATE sharing_content 
         SET content_title = ?, content_image = ?, content_description = ?, category = ?, 
             read_time = ?, published_date = ?, display_order = ?, status = ? 
         WHERE id = ?"
    );
    
    // sama seperti add, plus id (i) di akhir
    $stmt->bind_param(
        "ssssssisi",
        $data['content_title'], 
        $data['content_image'], 
        $data['content_description'], 
        $data['category'], 
        $data['read_time'], 
        $data['published_date'], 
        $data['display_order'],
        $data['status'],
        $id
    );
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Content updated successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to update content: ' . $conn->error];
}


/**
 * Delete sharing content
 */
function deleteSharingContent($id) {
    $conn = getDB();
    $stmt = $conn->prepare("DELETE FROM sharing_content WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Content deleted successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to delete content: ' . $conn->error];
}

/**
 * Get category badge color
 */
function getCategoryBadgeColor($category) {
    $colors = [
        'skincare' => '#ffd600',
        'health' => '#4CAF50',
        'lifestyle' => '#FF9800',
        'technology' => '#2196F3',
        'tutorial' => '#9C27B0',
        'other' => '#607D8B'
    ];
    
    return $colors[strtolower($category)] ?? '#ffd600';
}
?>
