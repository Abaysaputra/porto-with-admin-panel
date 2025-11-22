<?php
/**
 * About Me Page - Dynamic
 * File: about.php
 */

require_once 'includes/functions.php';
$profile = getProfile();
$education = getEducation();

if (!$profile) {
    die('Error: Profile data not found');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About <?= h($profile['full_name']) ?> - Portfolio</title>
    
    <!-- Bootstrap CSS 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-yellow: #FFD600;
            --primary-dark: #2c2c2c;
            --accent-orange: #FFC107;
            --bg-light: #f8f9fa;
            --text-dark: #212529;
            --text-gray: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        /* Header Navigation */
        .header-nav {
            padding: 30px 0 20px 0;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .back-button:hover {
            background: var(--primary-yellow);
            border-color: var(--primary-yellow);
            color: var(--primary-dark);
            transform: translateX(-5px);
            box-shadow: 0 4px 15px rgba(255, 214, 0, 0.3);
        }
        
        .back-button i {
            font-size: 24px;
        }
        
        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }
        
        .profile-image {
            width: 100%;
            max-width: 300px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .profile-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        
        .profile-content p {
            color: var(--text-gray);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .contact-info {
            margin: 20px 0;
        }
        
        .contact-info p {
            margin-bottom: 8px;
            color: var(--text-dark);
        }
        
        .contact-info strong {
            color: var(--primary-dark);
        }
        
        /* Social Media Buttons */
        .social-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }
        
        .btn-social {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .btn-social:hover {
            background: var(--primary-yellow);
            border-color: var(--primary-yellow);
            color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 214, 0, 0.3);
        }
        
        .btn-social i {
            margin-right: 8px;
            font-size: 20px;
        }
        
        /* Education Section */
        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-orange);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }
        
        .section-heading {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 40px;
        }
        
        .education-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-yellow);
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        
        .education-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .education-period {
            display: inline-block;
            background: var(--primary-yellow);
            color: var(--primary-dark);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .education-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }
        
        .education-school {
            color: var(--text-gray);
            font-size: 0.95rem;
        }
        
        /* Footer */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 60px 0 30px 0;
            margin-top: 80px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        
        .footer-left {
            flex: 1;
            min-width: 250px;
            margin-bottom: 30px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .footer-logo-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-yellow);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-dark);
        }
        
        .footer-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .footer-quote {
            color: rgba(255,255,255,0.8);
            font-style: italic;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-top: 15px;
        }
        
        .footer-right {
            display: flex;
            gap: 80px;
            flex-wrap: wrap;
        }
        
        .footer-links h6 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-links ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-links ul li {
            margin-bottom: 12px;
        }
        
        .footer-links ul li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s;
        }
        
        .footer-links ul li a:hover {
            color: var(--primary-yellow);
        }
        
        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .footer-social a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-social a:hover {
            background: var(--primary-yellow);
            color: var(--primary-dark);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            text-align: center;
        }
        
        .footer-bottom p {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin: 0;
        }
        
        .footer-bottom a {
            color: var(--primary-yellow);
            text-decoration: none;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .profile-card {
                padding: 25px;
            }
            
            .profile-content h1 {
                font-size: 2rem;
            }
            
            .section-heading {
                font-size: 1.5rem;
            }
            
            .profile-image {
                max-width: 250px;
                margin-bottom: 30px;
            }
            
            .footer-content {
                flex-direction: column;
            }
            
            .footer-right {
                gap: 40px;
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .social-buttons {
                flex-direction: column;
            }
            
            .btn-social {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <div class="container">
        <div class="header-nav">
            <a href="index.php#about" class="back-button" title="Back to Home">
                <i class='bx bx-arrow-back'></i>
            </a>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="container">
        <div class="profile-card">
            <div class="row align-items-center">
                <!-- Profile Image -->
                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                    <img src="<?= h($profile['profile_image']) ?>" alt="<?= h($profile['full_name']) ?>" class="profile-image">
                </div>
                
                <!-- Profile Content -->
                <div class="col-lg-8">
                    <div class="profile-content">
                        <h1><?= h($profile['full_name']) ?></h1>
                        <p><?= nl2br(h($profile['bio_long'] ?: $profile['bio_short'])) ?></p>
                        
                        <!-- Contact Info -->
                        <div class="contact-info">
                            <p><strong>Email:</strong> <a href="mailto:<?= h($profile['email']) ?>"><?= h($profile['email']) ?></a></p>
                        </div>
                        
                        <!-- Social Media Buttons -->
                        <div class="social-buttons">
                            <?php if ($profile['instagram']): ?>
                            <a href="https://instagram.com/<?= h($profile['instagram']) ?>" class="btn-social" target="_blank">
                                <i class='bx bxl-instagram'></i> Instagram
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($profile['linkedin']): ?>
                            <a href="https://linkedin.com/in/<?= h($profile['linkedin']) ?>" class="btn-social" target="_blank">
                                <i class='bx bxl-linkedin'></i> Linkedin
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($profile['threads']): ?>
                            <a href="https://threads.net/@<?= h($profile['threads']) ?>" class="btn-social" target="_blank">
                                <i class='bx bxl-meta'></i> Thread
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($profile['medium']): ?>
                            <a href="https://medium.com/@<?= h($profile['medium']) ?>" class="btn-social" target="_blank">
                                <i class='bx bxl-medium'></i> Medium
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Education Section -->
    <div class="container">
        <div class="section-title">MY EDUCATION</div>
        <h2 class="section-heading">Riwayat Pendidikan</h2>
        
        <div class="row">
            <?php if (!empty($education)): ?>
                <?php foreach ($education as $edu): ?>
                <div class="col-lg-6 mb-4">
                    <div class="education-card">
                        <span class="education-period">
                            <?= h($edu['period_start']) ?> - <?= h($edu['period_end']) ?>
                        </span>
                        <h3 class="education-title"><?= h($edu['degree']) ?></h3>
                        <p class="education-school"><?= h($edu['institution']) ?></p>
                        <?php if ($edu['description']): ?>
                            <p class="text-muted mt-2" style="font-size: 0.9rem;">
                                <?= h($edu['description']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada data pendidikan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Footer Left -->
                <div class="footer-left">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">
                            <?= strtoupper(substr(h($profile['full_name']), 0, 1)) ?>
                        </div>
                        <div class="footer-logo-text"><?= h($profile['full_name']) ?></div>
                    </div>
                    <p class="footer-quote">
                        <?= h(getSiteSetting('footer_quote') ?: '"Ketika kamu menginginkan sesuatu, segenap alam semesta akan bersatu padu membantumu meraihnya." - Paulo Coelho') ?>
                    </p>
                    <!-- Footer Social -->
                    <div class="footer-social">
                        <?php if ($profile['facebook']): ?>
                        <a href="https://facebook.com/<?= h($profile['facebook']) ?>" target="_blank">
                            <i class='bx bxl-facebook'></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($profile['twitter']): ?>
                        <a href="https://twitter.com/<?= h($profile['twitter']) ?>" target="_blank">
                            <i class='bx bxl-twitter'></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($profile['instagram']): ?>
                        <a href="https://instagram.com/<?= h($profile['instagram']) ?>" target="_blank">
                            <i class='bx bxl-instagram'></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($profile['linkedin']): ?>
                        <a href="https://linkedin.com/in/<?= h($profile['linkedin']) ?>" target="_blank">
                            <i class='bx bxl-linkedin'></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Footer Right -->
                <div class="footer-right">
                    <!-- Quick Links -->
                    <div class="footer-links">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Me</a></li>
                            <li><a href="index.php#portfolio">Portfolio</a></li>
                            <li><a href="index.php#contact">Contact Me</a></li>
                        </ul>
                    </div>
                    
                    <!-- Other Links -->
                    <div class="footer-links">
                        <h6>Other</h6>
                        <ul>
                            <li><a href="index.php#sharing">Sharing</a></li>
                            <li><a href="index.php#projects">Projects</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <a href="index.php"><?= h($profile['full_name']) ?></a> All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
