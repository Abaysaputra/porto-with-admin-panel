<?php
require_once '../../includes/functions.php';
require_once '../../includes/auth.php';

requireLogin();
$currentUser = getCurrentUser();
$education = getEducation();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Certificates - Portfolio Admin</title>
    
    <!-- Bootstrap CSS 4.5 -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <style>
    :root {
        --primary-yellow: #FFD600;
        --primary-dark: #1a1a1a;
        --accent-orange: #FFC107;
        --bg-light: #f8f9fa;
        --text-dark: #212529;
        --sidebar-width: 250px;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    html, body {
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
        height: 100%;
    }
    
    body {
        background-color: var(--bg-light);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    
    /* NAVBAR */
    .navbar-custom {
        background: linear-gradient(135deg, #1a1a1a 0%, #3d3d3d 100%);
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        height: 56px;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1030 !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .navbar-custom .navbar-brand {
        color: var(--primary-yellow) !important;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .navbar-custom .nav-link {
        color: #fff !important;
        transition: color 0.3s;
    }
    
    .navbar-custom .nav-link:hover {
        color: var(--primary-yellow) !important;
    }
    
    .text-warning-custom {
        color: var(--primary-yellow) !important;
    }
    
    /* SIDEBAR */
    .sidebar {
        position: fixed;
        top: 56px;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        background-color: #fff;
        width: var(--sidebar-width);
    }
    
    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 56px);
        padding-top: 1rem;
        overflow-x: hidden;
        overflow-y: auto;
    }
    
    .sidebar .nav-link {
        font-weight: 500;
        color: var(--text-dark);
        padding: 0.75rem 1rem;
        border-left: 3px solid transparent;
        transition: all 0.3s;
    }
    
    .sidebar .nav-link:hover {
        color: var(--accent-orange);
        background-color: rgba(255, 214, 0, 0.1);
        border-left-color: var(--primary-yellow);
    }
    
    .sidebar .nav-link.active {
        color: var(--text-dark);
        background-color: rgba(255, 214, 0, 0.2);
        border-left-color: var(--primary-yellow);
        font-weight: 700;
    }
    
    .sidebar .nav-link i {
        margin-right: 0.5rem;
        font-size: 1.25rem;
        vertical-align: middle;
    }
    
    .sidebar-heading {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        color: #6c757d;
        font-weight: 700;
        padding: 0.75rem 1rem;
        margin-top: 1rem;
    }
    
    /* MAIN CONTENT */
    main {
        margin-left: var(--sidebar-width);
        margin-top: 56px;
        padding: 2rem;
        min-height: calc(100vh - 56px);
    }
    
    .page-header {
        background: #FFD6001A;
        border-radius: 14px;
        padding: 24px 30px 18px 30px;
        margin-bottom: 32px;
    }
    
    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        color: #222;
    }
    
    .page-header p {
        margin-bottom: 0;
        color: #444;
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #222;
    }
    
   .btn-add-primary,
.btn-save-primary {
    background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
    border: none;
    color: var(--text-dark);
    font-weight: 700;
    padding: 12px 32px;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s;
    margin-bottom: 24px;
}

.btn-add-primary:hover,
.btn-save-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 214, 0, 0.4);
}

    
    /* CERTIFICATE LIST */
    .cert-list-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .cert-thumbnail {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .cert-info {
        flex: 1;
    }
    
    .cert-info h5 {
        margin: 0 0 8px 0;
        font-weight: 700;
    }
    
    .cert-info p {
        margin: 0 0 8px 0;
        color: #666;
        font-size: 0.9rem;
    }
    
    .cert-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-edit-small {
        background: #4F8EFF;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }
    
    .btn-edit-small:hover {
        background: #265fdd;
    }
    
    .btn-delete-small {
        background: #FF867C;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }
    
    .btn-delete-small:hover {
        background: #db504c;
    }
    
    .success-message {
        display: none;
        background: #4CAF50;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 16px;
        animation: slideDown 0.3s ease;
    }
    
    .success-message.show {
        display: block;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-dialog-custom {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .form-control, .form-select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-yellow);
        box-shadow: 0 0 0 3px rgba(255, 214, 0, 0.1);
        outline: none;
    }
    
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    
    @media (max-width: 767.98px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            width: 280px;
        }
        
        .sidebar.show {
            transform: translateX(0);
            box-shadow: 2px 0 20px rgba(0,0,0,0.3);
        }
        
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 56px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        
        .sidebar-backdrop.show {
            display: block;
        }
        
        main {
            margin-left: 0;
            padding: 1rem;
        }
        
        .cert-list-item {
            flex-direction: column;
            text-align: center;
        }
    }
    </style>
</head>

<body>
<!-- NAVBAR -->
<nav class="navbar navbar-dark sticky-top navbar-custom flex-md-nowrap shadow-sm">
    <a class="navbar-brand px-3 py-2" href="#">
        <i class='bx bxs-dashboard'></i> Admin Panel
    </a>
    
    <ul class="navbar-nav px-3 ml-auto d-none d-md-flex flex-row align-items-center">
        <li class="nav-item text-nowrap mr-3">
            <span class="text-white-50 small">
                Hi, <strong class="text-warning-custom"><?= h($currentUser['full_name']) ?></strong>
            </span>
        </li>
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="../login/index.php">
                <i class='bx bx-log-out'></i> Logout
            </a>
        </li>
    </ul>
    
    <button class="navbar-toggler d-md-none" type="button" id="sidebarToggle">
        <span class="line"></span>
    </button>
</nav>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class='bx bx-home-alt'></i> Dashboard
                        </a>
                    </li>
                </ul>
                
                <h6 class="sidebar-heading">Content Management</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="editdatadiri.php">
                            <i class='bx bx-user'></i> Edit Data Diri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="education.php">
                            <i class='bx bx-book-open'></i> Education
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="projects.php">
                            <i class='bx bx-folder'></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sertifikat.php">
                            <i class='bx bx-briefcase'></i> Sertifikat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sharing.php">
                            <i class='bx bx-share'></i> Sharing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php">
                            <i class='bx bx-log-out'></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

       <!-- MAIN CONTENT -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class='bx bx-book-open'></i> Education Management</h1>
        <p class="mb-0">Kelola riwayat pendidikan yang tampil di halaman About</p>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success" style="display:none;">
        <i class='bx bx-check-circle'></i> <span id="successText"></span>
    </div>

        <!-- Add New Button -->
        <div class="mb-3">
            <button class="btn-add-primary" onclick="openAddEduModal()">
                <i class='bx bx-plus'></i> Tambah Pendidikan
            </button>
        </div>


    <!-- Education List -->
    <div class="section-title">Riwayat Pendidikan</div>

    <div id="educationList">
        <?php if (!empty($education)): ?>
            <?php foreach ($education as $edu): ?>
            <div class="education-list-item d-flex justify-content-between align-items-center"
                 data-id="<?= $edu['id'] ?>"
                 style="border:1px solid #eee;border-radius:10px;padding:14px 18px;margin-bottom:10px;">
                 
                <div class="education-info">
                    <div class="education-period" style="font-size:0.85rem;color:#888;">
                        <?= h($edu['period_start']) ?> - <?= h($edu['period_end']) ?>
                    </div>
                    <h5 style="margin:4px 0;font-weight:700;"><?= h($edu['degree']) ?></h5>
                    <div style="font-size:0.9rem;color:#555;">
                        <?= h($edu['institution']) ?>
                    </div>
                    <?php if (!empty($edu['description'])): ?>
                        <div style="font-size:0.85rem;color:#777;margin-top:6px;">
                            <?= h(mb_strimwidth($edu['description'], 0, 120, '...')) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="education-actions">
                    <button class="btn-edit-small" onclick="editEducation(<?= $edu['id'] ?>)">
                        <i class='bx bx-edit'></i> Edit
                    </button>
                    <button class="btn-delete-small" onclick="deleteEducation(<?= $edu['id'] ?>)">
                        <i class='bx bx-trash'></i> Delete
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data pendidikan. Klik "Tambah Pendidikan" untuk menambahkan.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Add/Edit Modal -->
<div class="modal" id="educationModal">
    <div class="modal-dialog-custom">
        <h3 id="eduModalTitle">Tambah Pendidikan</h3>
        <form id="educationForm">
            <input type="hidden" id="eduId">

            <div class="mb-3">
                <label class="form-label">Periode Mulai *</label>
                <input type="text" class="form-control" id="periodStart" placeholder="2018" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Periode Selesai *</label>
                <input type="text" class="form-control" id="periodEnd" placeholder="Sekarang / 2022" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gelar / Program Studi *</label>
                <input type="text" class="form-control" id="degree" placeholder="S1 Sistem Informasi" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Institusi *</label>
                <input type="text" class="form-control" id="institution" placeholder="Nama Universitas / Sekolah" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" id="eduDescription" rows="3" placeholder="Kegiatan, fokus studi, organisasi, dll."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Urutan Tampilan</label>
                <input type="number" class="form-control" id="displayOrder" value="0">
            </div>

            <div class="d-flex justify-content-end gap-2" style="gap:10px;">
                <button type="button" class="btn btn-secondary" onclick="closeEduModal()">Cancel</button>
                <button type="submit" class="btn-add-primary">
                    <i class='bx bx-save'></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
// --- helper notif ---
function showEduSuccess(message) {
    $('#successText').text(message);
    $('#successMessage').fadeIn().delay(3000).fadeOut();
}

// --- modal helpers ---
function openAddEduModal() {
    console.log('openAddEduModal');
    $('#eduModalTitle').text('Tambah Pendidikan');
    $('#educationForm')[0].reset();
    $('#eduId').val('');
    $('#educationModal').addClass('active');
}

function closeEduModal() {
    console.log('closeEduModal');
    $('#educationModal').removeClass('active');
    $('#educationForm')[0].reset();
}

// --- ambil data untuk Edit (dipanggil dari onclick di HTML) ---
function editEducation(id) {
    console.log('editEducation', id);
    $.ajax({
        url: 'api/education_get.php',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(res) {
            console.log('GET education response:', res);
            if (!res.success) {
                alert('Error: ' + res.message);
                return;
            }
            const edu = res.data;
            $('#eduModalTitle').text('Edit Pendidikan');
            $('#eduId').val(edu.id);
            $('#periodStart').val(edu.period_start);
            $('#periodEnd').val(edu.period_end);
            $('#degree').val(edu.degree);
            $('#institution').val(edu.institution);
            $('#eduDescription').val(edu.description);
            $('#displayOrder').val(edu.display_order);
            $('#educationModal').addClass('active');
        },
        error: function(xhr, status, err) {
            console.error('GET error:', status, err, xhr.responseText);
            alert('Server error saat mengambil data pendidikan');
        }
    });
}

// --- hapus data (dipanggil dari onclick di HTML) ---
function deleteEducation(id) {
    if (!confirm('Yakin ingin menghapus riwayat pendidikan ini?')) return;

    $.ajax({
        url: 'api/education_delete.php',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(res) {
            console.log('DELETE response:', res);
            if (res.success) {
                showEduSuccess(res.message);
                $('[data-id="' + id + '"]').fadeOut(300, function() {
                    $(this).remove();
                });
            } else {
                alert('Error: ' + res.message);
            }
        },
        error: function(xhr, status, err) {
            console.error('DELETE error:', status, err, xhr.responseText);
            alert('Server error saat menghapus pendidikan');
        }
    });
}

// --- binding yang butuh jQuery, jalankan setelah DOM siap ---
$(function () {

    // submit form Add/Update
    $('#educationForm').on('submit', function(e) {
        e.preventDefault();
        console.log('educationForm submit');

        const formData = {
            id: $('#eduId').val(),
            period_start: $('#periodStart').val(),
            period_end: $('#periodEnd').val(),
            degree: $('#degree').val(),
            institution: $('#institution').val(),
            description: $('#eduDescription').val(),
            display_order: $('#displayOrder').val() || 0
        };

        console.log('POST education data:', formData);

        $.ajax({
            url: 'api/education_save.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                console.log('SAVE response:', res);
                if (res.success) {
                    showEduSuccess(res.message);
                    closeEduModal();
                    setTimeout(function() {
                        location.reload();
                    }, 1200);
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr, status, err) {
                console.error('SAVE error:', status, err, xhr.responseText);
                alert('Server error saat menyimpan pendidikan');
            }
        });
    });

    // klik di background modal untuk close
    $(document).on('click', '#educationModal', function(e) {
        if (e.target === this) {
            closeEduModal();
        }
    });
});
</script>

</body>
</html>
