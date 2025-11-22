<?php
/**
 * Debug Projects Save
 * File: admin/php/api/debug_projects_save.php
 */

// Enable full error display
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h2>Debug Projects Save API</h2>";
echo "<hr>";

// Test 1: Check file includes
echo "<h3>Test 1: File Includes</h3>";
try {
    require_once '../../../includes/functions.php';
    echo "✅ functions.php loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error loading functions.php: " . $e->getMessage() . "<br>";
    die();
}

// Test 2: Check getDB()
echo "<h3>Test 2: Database Connection</h3>";
try {
    $conn = getDB();
    echo "✅ Database connected<br>";
    echo "Database: " . DB_NAME . "<br>";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
    die();
}

// Test 3: Check fixDateFormat()
echo "<h3>Test 3: fixDateFormat() Function</h3>";
try {
    $testDate = fixDateFormat('2025');
    echo "✅ fixDateFormat('2025') = " . $testDate . "<br>";
} catch (Exception $e) {
    echo "❌ fixDateFormat error: " . $e->getMessage() . "<br>";
}

// Test 4: Simulate POST data
echo "<h3>Test 4: Simulate Save Project</h3>";
$_POST = [
    'project_name' => 'Test Debug Project',
    'project_image' => 'test.jpg',
    'short_description' => 'Short desc',
    'full_description' => 'Full desc',
    'technologies' => 'HTML, CSS',
    'project_url' => 'https://example.com',
    'start_date' => '',
    'end_date' => '',
    'category' => 'web',
    'is_featured' => 0,
    'display_order' => 0,
    'status' => 'completed'
];

echo "POST Data:<br>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

try {
    // Prepare data (sama seperti di projects_save.php)
    $data = [
        'project_name' => trim($_POST['project_name'] ?? ''),
        'project_image' => trim($_POST['project_image'] ?? ''),
        'short_description' => trim($_POST['short_description'] ?? ''),
        'full_description' => trim($_POST['full_description'] ?? ''),
        'technologies' => trim($_POST['technologies'] ?? ''),
        'project_url' => trim($_POST['project_url'] ?? ''),
        'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
        'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
        'category' => $_POST['category'] ?? 'web',
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
        'display_order' => intval($_POST['display_order'] ?? 0),
        'status' => $_POST['status'] ?? 'completed'
    ];
    
    echo "<br>Processed Data:<br>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
    // Fix dates
    if ($data['start_date'] !== null) {
        $data['start_date'] = fixDateFormat($data['start_date']);
    }
    
    if ($data['end_date'] !== null) {
        $data['end_date'] = fixDateFormat($data['end_date']);
    }
    
    echo "<br>After fixDateFormat:<br>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
    // Try to add project
    $result = addProject($data);
    
    echo "<br>Result:<br>";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
    
    if ($result['success']) {
        echo "<h3 style='color:green;'>✅ SUCCESS!</h3>";
        echo "<p>Project ID: " . $result['id'] . "</p>";
        
        // Clean up
        deleteProject($result['id']);
        echo "<p>Test project deleted.</p>";
    } else {
        echo "<h3 style='color:red;'>❌ FAILED</h3>";
        echo "<p>" . $result['message'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color:red;'>❌ EXCEPTION</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<p>Debug complete. Check output above for errors.</p>";
?>
