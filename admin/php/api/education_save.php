    <?php
    header('Content-Type: application/json');
    require_once '../../../includes/functions.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit;
    }

    $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;

    $data = [
        'period_start'  => trim($_POST['period_start'] ?? ''),
        'period_end'    => trim($_POST['period_end'] ?? ''),
        'degree'        => trim($_POST['degree'] ?? ''),
        'institution'   => trim($_POST['institution'] ?? ''),
        'description'   => trim($_POST['description'] ?? ''),
        'display_order' => isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0,
    ];

    // Validasi basic
    if ($data['period_start'] === '' || $data['period_end'] === '' || $data['degree'] === '' || $data['institution'] === '') {
        echo json_encode(['success' => false, 'message' => 'Periode, gelar, dan institusi wajib diisi']);
        exit;
    }

    if ($id) {
        $result = updateEducation($id, $data);
    } else {
        $result = addEducation($data);
    }

    echo json_encode($result);
