<?php
/**
 * Admin Dashboard
 * File: admin/index.php
 */

require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Proteksi halaman - redirect jika belum login
requireLogin();

// Get current user
$currentUser = getCurrentUser();

// Get statistics from database
$totalProjects = count(getProjects());
$totalCertificates = count(getCertificates());
$totalSharing = count(getSharingContent());
$profile = getProfile();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard - Portfolio Management</title>
    
    <!-- Bootstrap CSS 4.5 -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
        background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        margin-top: 0;
        color: var(--text-dark);
        box-shadow: 0 0.5rem 1rem rgba(255, 214, 0, 0.15);
    }
    
    .page-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .page-header p {
        margin-bottom: 0;
        opacity: 0.9;
    }
    
    .stat-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15) !important;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }
    
    .bg-gradient-yellow {
        background: linear-gradient(135deg, #FFD600 0%, #FFC107 100%);
    }
    
    .bg-gradient-blue {
        background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%);
    }
    
    .bg-gradient-green {
        background: linear-gradient(135deg, #66BB6A 0%, #4CAF50 100%);
    }
    
    .bg-gradient-purple {
        background: linear-gradient(135deg, #AB47BC 0%, #9C27B0 100%);
    }
    
    .quick-action-card {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15) !important;
        text-decoration: none;
        color: inherit;
    }
    
    .quick-action-card i {
        font-size: 2.5rem;
        color: var(--primary-yellow);
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-yellow);
        box-shadow: 0 0 0 0.2rem rgba(255, 214, 0, 0.25);
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-yellow) 0%, var(--accent-orange) 100%);
        border: none;
        color: var(--text-dark);
        font-weight: 700;
    }
    
    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-yellow) 100%);
        color: var(--text-dark);
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(255, 214, 0, 0.3);
    }
    
    .shadow-custom {
        box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,.075) !important;
    }
    
    .rounded-custom {
        border-radius: 0.5rem !important;
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
                Hi, <strong class="text-warning-custom"><?= h($currentUser['full_name']) ?></strong>
            </span>
        </li>
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="login/logout.php">
                <i class='bx bx-log-out'></i> Logout
            </a>
        </li>
    </ul>
    
    <!-- Modern Hamburger (mobile only) -->
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
                        <a class="nav-link active" href="index.php">
                            <i class='bx bx-home-alt'></i> Dashboard
                        </a>
                    </li>
                </ul>
                
                <h6 class="sidebar-heading">Content Management</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="php/editdatadiri.php">
                            <i class='bx bx-user'></i> Edit Data Diri
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="php/education.php">
                            <i class='bx bx-id-card'></i>Education
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/projects.php">
                            <i class='bx bx-folder'></i> Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/sertifikat.php">
                            <i class='bx bx-briefcase'></i> Sertifikat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/sharing.php">
                            <i class='bx bx-share'></i> Sharing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login/logout.php">
                            <i class='bx bx-log-out'></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <!-- Dashboard Home Page -->
            <div class="page-header">
                <h1><i class='bx bx-grid-alt'></i> Dashboard</h1>
                <p class="mb-0">Welcome back, <strong><?= h($currentUser['full_name']) ?></strong>! Here's your portfolio overview.</p>
            </div>
            
            <!-- Stats Row (Dynamic Data) -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-custom rounded-custom border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-gradient-yellow text-dark mr-3">
                                    <i class='bx bx-folder'></i>
                                </div>
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-1">Total Projects</div>
                                    <div class="h2 mb-0 font-weight-bold"><?= $totalProjects ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-custom rounded-custom border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-gradient-blue text-white mr-3">
                                    <i class='bx bx-award'></i>
                                </div>
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-1">Certificates</div>
                                    <div class="h2 mb-0 font-weight-bold"><?= $totalCertificates ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-custom rounded-custom border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-gradient-green text-white mr-3">
                                    <i class='bx bx-share'></i>
                                </div>
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-1">Sharing Content</div>
                                    <div class="h2 mb-0 font-weight-bold"><?= $totalSharing ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card shadow-custom rounded-custom border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-gradient-purple text-white mr-3">
                                    <i class='bx bx-user-check'></i>
                                </div>
                                <div>
                                    <div class="text-muted small font-weight-bold text-uppercase mb-1">Total Items</div>
                                    <div class="h2 mb-0 font-weight-bold"><?= $totalProjects + $totalCertificates + $totalSharing ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow-custom rounded-custom border-0 mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 font-weight-bold">Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="php/editdatadiri.php" class="quick-action-card d-block">
                                <div class="card shadow-sm rounded-custom border-0 text-center p-4 h-100">
                                    <i class='bx bx-user mb-3'></i>
                                    <h6 class="font-weight-bold mb-2">Edit Data Diri</h6>
                                    <p class="text-muted small mb-0">Update profile information</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="php/projects.php" class="quick-action-card d-block">
                                <div class="card shadow-sm rounded-custom border-0 text-center p-4 h-100">
                                    <i class='bx bx-folder mb-3'></i>
                                    <h6 class="font-weight-bold mb-2">Manage Projects</h6>
                                    <p class="text-muted small mb-0">Add or edit projects</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="php/sertifikat.php" class="quick-action-card d-block">
                                <div class="card shadow-sm rounded-custom border-0 text-center p-4 h-100">
                                    <i class='bx bx-award mb-3'></i>
                                    <h6 class="font-weight-bold mb-2">Manage Certificates</h6>
                                    <p class="text-muted small mb-0">Add or edit certificates</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="../index.php" class="quick-action-card d-block" target="_blank">
                                <div class="card shadow-sm rounded-custom border-0 text-center p-4 h-100">
                                    <i class='bx bx-world mb-3'></i>
                                    <h6 class="font-weight-bold mb-2">View Website</h6>
                                    <p class="text-muted small mb-0">Preview live portfolio</p>
                                </div>                              
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Information (Dynamic) -->
            <div class="card shadow-custom rounded-custom border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 font-weight-bold">System Information</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold border-top-0">Portfolio Owner</td>
                                    <td class="border-top-0"><?= h($profile['full_name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Owner Email</td>
                                    <td><?= h($profile['email']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Admin User</td>
                                    <td><?= h($currentUser['username']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Admin Email</td>
                                    <td><?= h($currentUser['email']) ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Last Login</td>
                                    <td><?= date('d M Y, H:i') ?> WIB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
    
    sidebar.find('.nav-link').on('click', function() {
        if (window.innerWidth < 768) {
            sidebarToggle.removeClass('active');
            sidebar.removeClass('show');
            backdrop.removeClass('show');
        }
    });
});
</script>
</body>
</html>