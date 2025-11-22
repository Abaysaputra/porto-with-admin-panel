<?php
/**
 * Projects Management - Admin Panel
 * File: admin/php/projects.php
 */

require_once '../../includes/functions.php';
require_once '../../includes/auth.php';
requireLogin();
$currentUser = getCurrentUser();
$profile = getProfile();
$projects = getProjects();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Projects - Portfolio Admin</title>
    
    <!-- Bootstrap CSS 4.5 -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
   <style>
    /* ========================================
       CSS VARIABLES - DEFINE FIRST
       ======================================== */
    :root {
        --primary-yellow: #FFD600;
        --primary-dark: #1a1a1a;
        --accent-orange: #FFC107;
        --bg-light: #f8f9fa;
        --text-dark: #212529;
        --sidebar-width: 250px;
    }
    
    /* ========================================
       RESET & BASE STYLES
       ======================================== */
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
    
    /* ========================================
       NAVBAR - FIXED TO TOP
       ======================================== */
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
    
    /* ========================================
       HAMBURGER MENU (MOBILE)
       ======================================== */
    .navbar-toggler {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border: 2px solid var(--primary-yellow);
        border-radius: 8px;
        padding: 0;
        background: transparent;
        transition: all 0.3s ease;
        z-index: 1050;
    }
    
    .navbar-toggler:hover {
        background: rgba(255, 214, 0, 0.15);
        border-color: var(--accent-orange);
    }
    
    .navbar-toggler:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(255, 214, 0, 0.25);
    }
    
    .navbar-toggler-icon {
        display: none !important;
    }
    
    .navbar-toggler::before,
    .navbar-toggler::after,
    .navbar-toggler .line {
        content: '';
        position: absolute;
        width: 22px;
        height: 2.5px;
        background: var(--primary-yellow);
        border-radius: 2px;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .navbar-toggler::before {
        top: 11px;
    }
    
    .navbar-toggler .line {
        top: 19.5px;
    }
    
    .navbar-toggler::after {
        bottom: 11px;
    }
    
    .navbar-toggler.active::before {
        top: 19.5px;
        transform: translateX(-50%) rotate(45deg);
    }
    
    .navbar-toggler.active .line {
        opacity: 0;
        transform: translateX(-50%) scale(0);
    }
    
    .navbar-toggler.active::after {
        bottom: 19.5px;
        transform: translateX(-50%) rotate(-45deg);
    }
    
    /* ========================================
       SIDEBAR
       ======================================== */
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
    
    /* ========================================
       MAIN CONTENT
       ======================================== */
    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .container-fluid .row {
        margin: 0 !important;
    }
    
    main {
        margin-left: var(--sidebar-width);
        margin-top: 56px;
        padding: 2rem;
        min-height: calc(100vh - 56px);
    }
    
    /* ========================================
       PAGE COMPONENTS
       ======================================== */
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
    
    /* ========================================
       PROJECTS FORM
       ======================================== */
    .section-title {
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #222;
    }
    
    .form-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(0,0,0,0.07), 0 1.5px 5px #e9e9e9;
        padding: 30px;
        margin-bottom: 24px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .form-control,
    .form-select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-yellow);
        box-shadow: 0 0 0 3px rgba(255, 214, 0, 0.1);
        outline: none;
    }
    
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    
    .file-upload-box {
        border: 2px dashed #d0d0d0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fafafa;
    }
    
    .file-upload-box:hover {
        border-color: var(--primary-yellow);
        background: rgba(255, 214, 0, 0.05);
    }
    
    .file-upload-box input[type="file"] {
        display: none;
    }
    
    .file-upload-label {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    .btn-save-primary {
        background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
        border: none;
        color: var(--text-dark);
        font-weight: 700;
        padding: 12px 32px;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .btn-save-primary:hover {
        background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-yellow) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 214, 0, 0.4);
    }
    
    .success-message {
        display: none;
        background: #4CAF50;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-top: 16px;
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
    /* Additional CSS for project list */
    .project-list-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .project-thumbnail {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .project-info {
        flex: 1;
    }
    
    .project-actions {
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
    }
    
    .btn-delete-small {
        background: #FF867C;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
    }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-content-custom {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }
    /* ========================================
       MOBILE RESPONSIVE
       ======================================== */
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
            margin-top: 56px;
            padding: 1rem;
        }
    }
</style>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-dark sticky-top navbar-custom flex-md-nowrap shadow-sm">
    <a class="navbar-brand px-3 py-2" href="#">
        <i class='bx bxs-dashboard'></i> Admin Panel
    </a>
    
    <!-- User info (desktop only) -->
    <ul class="navbar-nav px-3 ml-auto d-none d-md-flex flex-row align-items-center">
        <li class="nav-item text-nowrap mr-3">
            <span class="text-white-50 small">
                Hi, <strong class="text-warning-custom">Test User</strong>
            </span>
        </li>
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="../login/index.php">
                <i class='bx bx-log-out'></i> LogOut
            </a>
        </li>
    </ul>
    
    <!-- Modern Hamburger (mobile only, positioned right) -->
    <button class="navbar-toggler d-md-none" type="button" id="sidebarToggle">
        <span class="line"></span>
    </button>
</nav>

<!-- Backdrop for mobile -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class='bx bx-home-alt'></i>
                            Dashboard
                        </a>
                    </li>
                </ul>
                
                <h6 class="sidebar-heading">Content Management</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="editdatadiri.php">
                            <i class='bx bx-user'></i>
                            Edit Data Diri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="projects.php">
                            <i class='bx bx-folder'></i>
                            Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sertifikat.php">
                            <i class='bx bx-briefcase'></i>
                            Sertifikat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sharing.php">
                            <i class='bx bx-share'></i>
                            Sharing
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
                <h1><i class='bx bx-folder'></i> Projects Management</h1>
                <p class="mb-0">Kelola proyek pilihan yang ditampilkan di portfolio</p>
            </div>
            
            <!-- Success Message -->
            <div id="successMessage" class="alert alert-success" style="display:none;">
                <i class='bx bx-check-circle'></i> <span id="successText"></span>
            </div>
            
            <!-- Add New Button -->
            <div class="mb-3">
                <button class="btn-save-primary" onclick="openAddModal()">
                    <i class='bx bx-plus'></i> Add New Project
                </button>
            </div>
            
            <!-- Projects List -->
            <div class="section-title">Your Projects</div>
            
            <div id="projectsList">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                    <div class="project-list-item" data-id="<?= $project['id'] ?>">
                        <img src="../../<?= h($project['project_image']) ?>" alt="<?= h($project['project_name']) ?>" class="project-thumbnail" onerror="this.src='../../assets/img/placeholder.jpg'">
                        
                        <div class="project-info">
                            <h5 style="margin: 0 0 8px 0; font-weight: 700;"><?= h($project['project_name']) ?></h5>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;"><?= h(substr($project['short_description'], 0, 100)) ?>...</p>
                            <div style="margin-top: 8px;">
                                <span class="badge badge-secondary"><?= h($project['category']) ?></span>
                                <?php if ($project['is_featured']): ?>
                                    <span class="badge badge-warning">Featured</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="project-actions">
                            <button class="btn-edit-small" onclick="editProject(<?= $project['id'] ?>)">
                                <i class='bx bx-edit'></i> Edit
                            </button>
                            <button class="btn-delete-small" onclick="deleteProject(<?= $project['id'] ?>)">
                                <i class='bx bx-trash'></i> Delete
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada project. Klik "Add New Project" untuk menambahkan.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal" id="projectModal">
    <div class="modal-content-custom">
        <h3 id="modalTitle">Add New Project</h3>

        <!-- PENTING: enctype untuk upload file -->
        <form id="projectForm" enctype="multipart/form-data">
            <input type="hidden" id="projectId" name="id">
            <input type="hidden" id="existingImage" name="existing_image">

            <div class="mb-3">
                <label class="form-label">Project Name *</label>
                <input type="text" class="form-control" id="projectName" name="project_name" required>
            </div>

            <!-- Ganti input path → upload file + preview -->
            <div class="mb-3">
                <label class="form-label">Project Image</label>

                <div class="custom-upload-wrapper">
                    <div class="image-preview" style="border:1px dashed #ddd; padding:10px; border-radius:8px; text-align:center;">
                        <img id="projectImagePreview" src="" alt="Preview" 
                             style="max-width:100%; max-height:180px; display:none; border-radius:6px;">
                        <div id="projectImagePlaceholder" style="color:#999; font-size:0.9rem;">
                            Belum ada gambar dipilih
                        </div>
                    </div>

                    <label class="btn btn-outline-secondary btn-sm mt-2" style="cursor:pointer;">
                        <i class='bx bx-upload'></i> Pilih Gambar
                        <input type="file" id="projectImage" name="project_image" accept="image/*" style="display:none;">
                    </label>

                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, WEBP. Maksimal 2MB.
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-control" id="projectCategory" name="category">
                    <option value="web">Web Development</option>
                    <option value="mobile">Mobile App</option>
                    <option value="design">Design</option>
                    <option value="data">Data Science</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Project URL</label>
                <input type="url" class="form-control" id="projectUrl" name="project_url" placeholder="https://example.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Technologies (comma-separated)</label>
                <input type="text" class="form-control" id="technologies" name="technologies" placeholder="HTML, CSS, JavaScript, React">
            </div>

            <div class="mb-3">
                <label class="form-label">Short Description *</label>
                <textarea class="form-control" id="shortDescription" name="short_description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Full Description</label>
                <textarea class="form-control" id="fullDescription" name="full_description" rows="5"></textarea>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isFeatured" name="is_featured" value="1">
                    <label class="form-check-label" for="isFeatured">
                        Featured (tampil di halaman utama)
                    </label>
                </div>
            </div>

            <!-- Display order dan status bisa hidden kalau mau -->
            <input type="hidden" name="display_order" value="0">
            <input type="hidden" name="status" value="completed">

            <div class="d-flex justify-content-end gap-2" style="gap: 10px;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-save-primary">
                    <i class='bx bx-save'></i> Save Project
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ========================================
// SIDEBAR TOGGLE & PAGE INITIALIZATION
// ========================================
$(document).ready(function() {
    const sidebarToggle = $('#sidebarToggle');
    const sidebar = $('#sidebarMenu');
    const backdrop = $('#sidebarBackdrop');
    
    // Sidebar toggle untuk mobile
    sidebarToggle.on('click', function() {
        $(this).toggleClass('active');
        sidebar.toggleClass('show');
        backdrop.toggleClass('show');
    });
    
    // Close sidebar when clicking backdrop
    backdrop.on('click', function() {
        sidebarToggle.removeClass('active');
        sidebar.removeClass('show');
        backdrop.removeClass('show');
    });
    
    // Close modal when clicking outside
    $(document).on('click', '#projectModal', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
});

// ========================================
// MODAL FUNCTIONS
// ========================================

// Open modal untuk add new project
function resetImagePreview() {
    $('#projectImage').val('');
    $('#existingImage').val('');
    $('#projectImagePreview').attr('src', '').hide();
    $('#projectImagePlaceholder').show();
}

// Open modal untuk add new project
function openAddModal() {
    $('#modalTitle').text('Add New Project');
    $('#projectForm')[0].reset();
    $('#projectId').val('');
    resetImagePreview();
    $('#projectModal').addClass('active');
}

// Close modal
function closeModal() {
    $('#projectModal').removeClass('active');
    $('#projectForm')[0].reset();
    resetImagePreview();
}
// Preview image saat pilih file
$('#projectImage').on('change', function () {
    const file = this.files[0];
    if (!file) {
        resetImagePreview();
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#projectImagePreview').attr('src', e.target.result).show();
        $('#projectImagePlaceholder').hide();
    };
    reader.readAsDataURL(file);
});


// ========================================
// CRUD OPERATIONS
// ========================================

// Edit project
function editProject(id) {
    $.ajax({
        url: 'api/projects_get.php?id=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const project = response.data;

                $('#modalTitle').text('Edit Project');

                $('#projectId').val(project.id);
                $('#projectName').val(project.project_name);
                $('#shortDescription').val(project.short_description);
                $('#fullDescription').val(project.full_description);
                $('#technologies').val(project.technologies);
                $('#projectUrl').val(project.project_url);
                $('#startDate').val(project.start_date);
                $('#endDate').val(project.end_date);
                $('#projectCategory').val(project.category);
                $('#isFeatured').prop('checked', project.is_featured == 1);

                // simpan path lama di hidden
                $('#existingImage').val(project.project_image);

                // tampilkan preview gambar lama (kalau ada)
                if (project.project_image) {
                    $('#projectImagePreview')
                        .attr('src', '../../' + project.project_image)
                        .show();
                    $('#projectImagePlaceholder').hide();
                } else {
                    resetImagePreview();
                }

                // kosongkan input file
                $('#projectImage').val('');

                $('#projectModal').addClass('active');
            } else {
                alert('❌ Failed to load project: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching project data:', error);
            alert('❌ Error fetching project data. Check console for details.');
        }
    });
}

// Save project (Add or Update)
$('#projectForm').on('submit', function (e) {
    e.preventDefault();

    const form = document.getElementById('projectForm');
    const formData = new FormData(form); // otomatis ambil semua field, termasuk file

    // Debug
    console.log('📤 Sending FormData...');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    $.ajax({
        url: 'api/projects_save.php',
        method: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,   // PENTING untuk FormData
        contentType: false,   // PENTING untuk FormData
        timeout: 15000,
        success: function (response) {
            console.log('📥 Response:', response);

            if (response.success) {
                showSuccess(response.message);
                closeModal();

                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                alert('❌ Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('❌ AJAX Error:', error);
            console.error('📋 Status:', status);
            console.error('📄 Response Text:', xhr.responseText);

            let errorMsg = 'Server error occurred.';
            try {
                const errorData = JSON.parse(xhr.responseText);
                if (errorData.message) errorMsg = errorData.message;
            } catch (e) {
                if (xhr.responseText) {
                    errorMsg = xhr.responseText.substring(0, 200);
                }
            }

            alert('❌ Error: ' + errorMsg);
        }
    });
});

// Delete project
function deleteProject(id) {
    if (!confirm('⚠️ Are you sure you want to delete this project?')) {
        return;
    }
    
    $.ajax({
        url: 'api/projects_delete.php',
        method: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showSuccess(response.message);
                
                // Remove item from DOM with animation
                $('[data-id="' + id + '"]').fadeOut(300, function() {
                    $(this).remove();
                });
            } else {
                alert('❌ Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting project:', error);
            alert('❌ Error deleting project. Check console for details.');
        }
    });
}

// ========================================
// UTILITY FUNCTIONS
// ========================================

// Show success message
function showSuccess(message) {
    $('#successText').text(message);
    $('#successMessage').fadeIn().delay(3000).fadeOut();
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, function(m) { 
        return map[m]; 
    });
}
</script>


</script>
</body>
</html>
