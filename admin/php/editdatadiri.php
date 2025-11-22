<?php
/**
 * Edit Data Diri - Admin Panel
 * File: admin/php/editdatadiri.php
 */

require_once '../../includes/auth.php'; 
requireLogin();
$currentUser = getCurrentUser();
$profile = getProfile();

if (!$profile) {
    die('Error: Profile data not found');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Data Diri - Portfolio Admin</title>
    
    <!-- Bootstrap CSS 4.5 -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- COPY PASTE SEMUA CSS DARI FILE ASLI KAMU DI SINI -->
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
       DATA DIRI TABLE
       ======================================== */
    .section-title {
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #222;
    }
    
    .datadiri-table-wrapper {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(0,0,0,0.07), 0 1.5px 5px #e9e9e9;
        padding: 0;
        margin-bottom: 36px;
        overflow: hidden;
    }
    
    .datadiri-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 720px;
        margin: 0;
    }
    
    .datadiri-table th,
    .datadiri-table td {
        padding: 15px 18px;
        font-size: 1rem;
        text-align: left;
        vertical-align: middle;
    }
    
    .datadiri-table th {
        background: #fafbfc;
        color: #353535;
        font-weight: 700;
        border-bottom: 2px solid #f0f0f0;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .datadiri-table td {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .datadiri-table tr:last-child td {
        border-bottom: none;
    }
    
    .datadiri-table tbody tr:hover {
        background-color: #f9f9f9;
    }
    
    .btn-edit {
        background: #4F8EFF;
        color: #fff;
        border-radius: 6px;
        border: none;
        padding: 8px 22px;
        margin-right: 6px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    
    .btn-edit:hover {
        background: #265fdd;
    }
    
    .btn-delete {
        background: #FF867C;
        color: #fff;
        border-radius: 6px;
        border: none;
        padding: 8px 20px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    
    .btn-delete:hover {
        background: #db504c;
    }
    
    .pagination-bottom {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 36px;
        padding: 15px 24px 18px 24px;
        background: #fff;
        border-top: 1px solid #f0f0f0;
    }
    
    .pagination-bottom select {
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #E0E0E0;
        font-size: 0.95rem;
        cursor: pointer;
    }
    
    .pagination-arrow-group {
        display: flex;
        gap: 3px;
    }
    
    .btn-paginate {
        background: #f3f3f3;
        color: #4F4F4F;
        border-radius: 50%;
        border: none;
        padding: 4px 9px;
        margin-left: 3px;
        font-size: 1.19rem;
        cursor: pointer;
        transition: background 0.18s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-paginate:disabled {
        opacity: 0.45;
        pointer-events: none;
    }
    
    .btn-paginate:hover:not(:disabled) {
        background: #FFD600;
        color: #232323;
    }
    
    /* Editing mode styles */
    .datadiri-table td.editing {
        padding: 8px 18px;
    }
    
    .datadiri-table td.editing input {
        width: 100%;
        padding: 8px 12px;
        border: 2px solid #4F8EFF;
        border-radius: 6px;
        font-size: 1rem;
        outline: none;
    }
    
    .btn-save {
        background: #4CAF50;
        color: #fff;
        border-radius: 6px;
        border: none;
        padding: 8px 22px;
        margin-right: 6px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .btn-save:hover {
        background: #388E3C;
    }
    
    .btn-cancel {
        background: #9E9E9E;
        color: #fff;
        border-radius: 6px;
        border: none;
        padding: 8px 20px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .btn-cancel:hover {
        background: #757575;
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
        
        .datadiri-table {
            min-width: 580px;
            font-size: 0.98rem;
        }
        
        .pagination-bottom {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
    
    @media (max-width: 700px) {
        .datadiri-table {
            font-size: 0.91rem;
        }
        
        .datadiri-table th,
        .datadiri-table td {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    </style>
</head>

<body>
<!-- NAVBAR (sama seperti aslinya) -->
<nav class="navbar navbar-dark sticky-top navbar-custom flex-md-nowrap shadow-sm">
    <a class="navbar-brand px-3 py-2" href="#">
        <i class='bx bxs-dashboard'></i> Admin Panel
    </a>
    
    <ul class="navbar-nav px-3 ml-auto d-none d-md-flex flex-row align-items-center">
        <li class="nav-item text-nowrap mr-3">
            <span class="text-white-50 small">
                Hi, <strong class="text-warning-custom">admin</strong>
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

<!-- Backdrop for mobile -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR (sama seperti aslinya) -->
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
                        <a class="nav-link active" href="editdatadiri.php">
                            <i class='bx bx-user'></i>
                            Edit Data Diri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projects.php">
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
                <h1><i class='bx bx-user'></i> Edit Data Diri</h1>
                <p class="mb-0">Kelola informasi personal dan social media profiles</p>
            </div>
            
            <!-- Success Message -->
            <div id="successMessage" class="alert alert-success" style="display:none;">
                <i class='bx bx-check-circle'></i> <span id="successText"></span>
            </div>
            
            <!-- Section Title -->
            <div class="section-title">Data Diri</div>
            
            <!-- Data Table Wrapper -->
            <div class="datadiri-table-wrapper">
                <div class="table-responsive">
                    <table class="datadiri-table">
                        <thead>
                            <tr>
                                <th style="width: 24%;">Field</th>
                                <th>Isi</th>
                                <th style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Nama Lengkap -->
                            <tr data-field="full_name">
                                <td><strong>Nama Lengkap</strong></td>
                                <td class="data-value"><?= h($profile['full_name']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Title/Jabatan -->
                            <tr data-field="title">
                                <td><strong>Title/Jabatan</strong></td>
                                <td class="data-value"><?= h($profile['title']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Email -->
                            <tr data-field="email">
                                <td><strong>Email</strong></td>
                                <td class="data-value"><?= h($profile['email']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Telepon -->
                            <tr data-field="phone">
                                <td><strong>Telepon</strong></td>
                                <td class="data-value"><?= h($profile['phone']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Lokasi -->
                            <tr data-field="location">
                                <td><strong>Lokasi</strong></td>
                                <td class="data-value"><?= h($profile['location']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Instagram -->
                            <tr data-field="instagram">
                                <td><strong>Instagram</strong></td>
                                <td class="data-value"><?= h($profile['instagram']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- LinkedIn -->
                            <tr data-field="linkedin">
                                <td><strong>LinkedIn</strong></td>
                                <td class="data-value"><?= h($profile['linkedin']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- GitHub -->
                            <tr data-field="github">
                                <td><strong>GitHub</strong></td>
                                <td class="data-value"><?= h($profile['github']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Medium -->
                            <tr data-field="medium">
                                <td><strong>Medium</strong></td>
                                <td class="data-value"><?= h($profile['medium']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                            
                            <!-- Threads -->
                            <tr data-field="threads">
                                <td><strong>Threads</strong></td>
                                <td class="data-value"><?= h($profile['threads']) ?></td>
                                <td class="actions">
                                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar toggle functionality
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
    $('#successMessage').fadeIn().delay(3000).fadeOut();
}

// Edit row functionality
function editRow(button) {
    const row = button.closest('tr');
    const dataCell = row.querySelector('.data-value');
    const actionsCell = row.querySelector('.actions');
    const currentValue = dataCell.textContent.trim();
    const field = row.getAttribute('data-field');
    
    // Change to editing mode
    dataCell.classList.add('editing');
    dataCell.innerHTML = `<input type="text" value="${currentValue}" class="edit-input form-control" />`;
    
    // Change buttons to Save/Cancel
    actionsCell.innerHTML = `
        <button class="btn-save" onclick="saveRow(this)">Save</button>
        <button class="btn-cancel" onclick="cancelEdit(this, '${currentValue.replace(/'/g, "\\'")}')">Cancel</button>
    `;
    
    // Focus on input
    dataCell.querySelector('input').focus();
}

// Save edited row
function saveRow(button) {
    const row = button.closest('tr');
    const dataCell = row.querySelector('.data-value');
    const actionsCell = row.querySelector('.actions');
    const input = dataCell.querySelector('input');
    const newValue = input.value.trim();
    const field = row.getAttribute('data-field');
    
    if (!newValue) {
        alert('❌ Value cannot be empty');
        return;
    }
    
    // Send AJAX request
    $.ajax({
        url: 'api/profile_update.php',
        method: 'POST',
        data: {
            field: field,
            value: newValue
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update cell value
                dataCell.classList.remove('editing');
                dataCell.textContent = newValue;
                
                // Restore Edit button
                actionsCell.innerHTML = `
                    <button class="btn-edit" onclick="editRow(this)">Edit</button>
                `;
                
                // Show success message
                showSuccess(`Data berhasil diubah!`);
            } else {
                alert('❌ Error: ' + response.message);
            }
        },
        error: function() {
            alert('❌ Server error. Please try again.');
        }
    });
}

// Cancel editing
function cancelEdit(button, originalValue) {
    const row = button.closest('tr');
    const dataCell = row.querySelector('.data-value');
    const actionsCell = row.querySelector('.actions');
    
    // Restore original value
    dataCell.classList.remove('editing');
    dataCell.textContent = originalValue;
    
    // Restore Edit button
    actionsCell.innerHTML = `
        <button class="btn-edit" onclick="editRow(this)">Edit</button>
    `;
}
</script>
</body>
</html>
