<?php
/**
 * Certificates Management - Admin Panel
 * File: admin/php/sertifikat.php
 */

require_once '../../includes/functions.php';
require_once '../../includes/auth.php';
requireLogin();
$currentUser = getCurrentUser();
$profile = getProfile();
$certificates = getCertificates();
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
    
    .btn-add-primary {
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
    
    .btn-add-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 214, 0, 0.4);
    }
        
    .btn-cancel-primary {
        /* rubah background menjadi abu linear gradient*/
        background: linear-gradient(135deg, #e0e0e0 0%, #c0c0c0 100%);
        border: none;
        color: var(--text-dark);
        font-weight: 700;
        padding: 12px 32px;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
        margin-bottom: 24px;
    }
    
    .btn-cancel-primary:hover {
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
                Hi, <strong class="text-warning-custom"><?= h($profile['full_name']) ?></strong>
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
                        <a class="nav-link" href="projects.php">
                            <i class='bx bx-folder'></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sertifikat.php">
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
                <h1><i class='bx bx-briefcase'></i> Certificates Management</h1>
                <p class="mb-0">Kelola sertifikat dan prestasi yang ditampilkan di portfolio</p>
            </div>
            
            <!-- Success Message -->
            <div id="successMessage" class="success-message">
                <i class='bx bx-check-circle'></i> <span id="successText"></span>
            </div>
            
            <!-- Add New Button -->
            <button class="btn-add-primary" onclick="openAddModal()">
                <i class='bx bx-plus-circle'></i> Tambah Sertifikat
            </button>
            
            <!-- Certificate List -->
            <div class="section-title">Your Certificates</div>
            
            <div id="certificatesList">
                <?php if (!empty($certificates)): ?>
                    <?php foreach ($certificates as $cert): ?>
                    <div class="cert-list-item" data-id="<?= $cert['id'] ?>">
                        <img src="../../<?= h($cert['certificate_image']) ?>" alt="<?= h($cert['certificate_title']) ?>" class="cert-thumbnail" onerror="this.src='../../assets/img/placeholder.jpg'">
                        
                        <div class="cert-info">
                            <h5><?= h($cert['certificate_title']) ?></h5>
                            <p><strong><?= h($cert['issuing_organization']) ?></strong></p>
                            <p><?= formatCertificateDate($cert['issue_date']) ?></p>
                            <div>
                                <span class="badge badge-secondary"><?= h(ucfirst($cert['category'])) ?></span>
                                <?php if ($cert['is_featured']): ?>
                                    <span class="badge badge-warning">Featured</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="cert-actions">
                            <button class="btn-edit-small" onclick="editCertificate(<?= $cert['id'] ?>)">
                                <i class='bx bx-edit'></i> Edit
                            </button>
                            <button class="btn-delete-small" onclick="deleteCertificate(<?= $cert['id'] ?>)">
                                <i class='bx bx-trash'></i> Delete
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada sertifikat. Klik "Tambah Sertifikat" untuk menambahkan.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal" id="certificateModal">
    <div class="modal-dialog-custom">
        <h3 id="modalTitle">Tambah Sertifikat</h3>

        <!-- PENTING: enctype untuk upload file -->
        <form id="certificateForm" enctype="multipart/form-data">
            <input type="hidden" id="certificateId" name="id">
            <input type="hidden" id="existingImage" name="existing_image">

            <div class="mb-3">
                <label class="form-label">Certificate Title *</label>
                <input type="text" class="form-control" id="certificateTitle" name="certificate_title" required>
            </div>

            <!-- Upload file + preview -->
            <div class="mb-3">
                <label class="form-label">Certificate Image</label>

                <div class="custom-upload-wrapper">
                    <div class="image-preview" style="border:1px dashed #ddd; padding:10px; border-radius:8px; text-align:center;">
                        <img id="certificateImagePreview" src="" alt="Preview"
                             style="max-width:100%; max-height:180px; display:none; border-radius:6px;">
                        <div id="certificateImagePlaceholder" style="color:#999; font-size:0.9rem;">
                            Belum ada gambar dipilih
                        </div>
                    </div>

                    <label class="btn btn-outline-secondary btn-sm mt-2" style="cursor:pointer;">
                        <i class='bx bx-upload'></i> Pilih Gambar
                        <input type="file" id="certificateImage" name="certificate_image" accept="image/*" style="display:none;">
                    </label>

                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, WEBP. Maksimal 2MB.
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Issuing Organization</label>
                <input type="text" class="form-control" id="issuingOrg" name="issuing_organization" placeholder="Organization name">
            </div>

            <div class="mb-3">
                <label class="form-label">Issue Date</label>
                <input type="date" class="form-control" id="issueDate" name="issue_date">
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="course">Course</option>
                    <option value="achievement">Achievement</option>
                    <option value="competition">Competition</option>
                    <option value="workshop">Workshop</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Credential ID</label>
                <input type="text" class="form-control" id="credentialId" name="credential_id" placeholder="Optional">
            </div>

            <div class="mb-3">
                <label class="form-label">Credential URL</label>
                <input type="url" class="form-control" id="credentialUrl" name="credential_url" placeholder="https://example.com/verify">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isFeatured" name="is_featured" value="1">
                    <label class="form-check-label" for="isFeatured">
                        Featured (tampil di halaman utama)
                    </label>
                </div>
            </div>

            <!-- display_order default 0 -->
            <input type="hidden" name="display_order" value="0">

            <div class="d-flex justify-content-end gap-2" style="gap: 10px;">
                <button type="button" class="btn-cancel-primary me-2" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-add-primary">
                    <i class='bx bx-save'></i> Save Certificate
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar toggle
$(document).ready(function() {
    const sidebarToggle = $('#sidebarToggle');
    const sidebar = $('#sidebarMenu');
    const backdrop = $('#sidebarBackdrop');
    
    sidebarToggle.on('click', function() {
        $(this).toggleClass('active');
        sidebar.toggleClass('show');
        backdrop.toggleClass('show');
    });
    
    backdrop.on('click', function() {
        sidebarToggle.removeClass('active');
        sidebar.removeClass('show');
        backdrop.removeClass('show');
    });
});

// Show success message
function showSuccess(message) {
    $('#successText').text(message);
    $('#successMessage').addClass('show').delay(3000).queue(function() {
        $(this).removeClass('show').dequeue();
    });
}
function resetCertificateImagePreview() {
    $('#certificateImage').val('');
    $('#existingImage').val('');
    $('#certificateImagePreview').attr('src', '').hide();
    $('#certificateImagePlaceholder').show();
}

// Open add modal
function openAddModal() {
    $('#modalTitle').text('Tambah Sertifikat');
    $('#certificateForm')[0].reset();
    $('#certificateId').val('');
    resetCertificateImagePreview();
    $('#certificateModal').addClass('active');
}

// Close modal
function closeModal() {
    $('#certificateModal').removeClass('active');
    $('#certificateForm')[0].reset();
    resetCertificateImagePreview();
}

// Preview image saat pilih file
$('#certificateImage').on('change', function () {
    const file = this.files[0];
    if (!file) {
        resetCertificateImagePreview();
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#certificateImagePreview').attr('src', e.target.result).show();
        $('#certificateImagePlaceholder').hide();
    };
    reader.readAsDataURL(file);
});



function editCertificate(id) {
    $.ajax({
        url: 'api/certificates_get.php?id=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const cert = response.data;

                $('#modalTitle').text('Edit Certificate');
                $('#certificateId').val(cert.id);
                $('#certificateTitle').val(cert.certificate_title);
                $('#issuingOrg').val(cert.issuing_organization);
                $('#issueDate').val(cert.issue_date);
                $('#category').val(cert.category);
                $('#credentialId').val(cert.credential_id);
                $('#credentialUrl').val(cert.credential_url);
                $('#description').val(cert.description);
                $('#isFeatured').prop('checked', cert.is_featured == 1);

                // simpan path lama
                $('#existingImage').val(cert.certificate_image || '');

                // preview gambar lama kalau ada
                if (cert.certificate_image) {
                    $('#certificateImagePreview')
                        .attr('src', '../../' + cert.certificate_image)
                        .show();
                    $('#certificateImagePlaceholder').hide();
                } else {
                    resetCertificateImagePreview();
                }

                // kosongkan input file
                $('#certificateImage').val('');

                $('#certificateModal').addClass('active');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Server error');
        }
    });
}


// Save certificate (ADD / UPDATE)
$('#certificateForm').on('submit', function(e) {
    e.preventDefault();

    const form = document.getElementById('certificateForm');
    const formData = new FormData(form);

    // (Opsional) debug
    console.log('📤 Sending Certificate FormData...');
    for (let [k, v] of formData.entries()) {
        console.log(k, v);
    }

    $.ajax({
        url: 'api/certificates_save.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                showSuccess(response.message);
                closeModal();
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Cert save error:', status, error, xhr.responseText);
            alert('Server error');
        }
    });
});



// Delete certificate
function deleteCertificate(id) {
    if (!confirm('Are you sure you want to delete this certificate?')) {
        return;
    }
    
    $.ajax({
        url: 'api/certificates_delete.php',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showSuccess(response.message);
                $('[data-id="' + id + '"]').fadeOut(300, function() {
                    $(this).remove();
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function() {
            alert('Server error');
        }
    });
}
</script>
</body>
</html>
