<?php
/**
 * Landing Page - Dynamic
 * File: index.php
 */

require_once 'includes/functions.php';
$profile = getProfile();
$featured_projects = getProjects(3, true);
$certificates = getCertificates(3, true);
$sharing_content = getSharingContent();
$all_projects = getProjects();
$all_certificates = getCertificates();
$all_sharing = getSharingContent();

if (!$profile) {
    die('Error: Profile data not found');
}

/**
 * Helper untuk gambar: kalau kosong → pakai placeholder.
 * Path yang disimpan di DB sekarang seperti: uploads/projects/xxx.jpg
 */
function safe_image($path, $placeholder = 'assets/img/placeholder.jpg') {
    return h(!empty($path) ? $path : $placeholder);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title><?= h($profile['full_name']) ?> - Portfolio</title>
    <meta content="Portfolio Website Rasya Nazhimah Marta Putri" name="description">
    <meta content="portfolio, web developer, sistem informasi" name="keywords">
    
    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/logo.png" rel="apple-touch-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<!-- ======= Top Navbar ======= -->
<nav class="top-navbar">
  <div class="navbar-container">
    <div class="navbar-brand">
      <img src="assets/img/logo.png" alt="Logo" class="navbar-logo">
      <span class="brand-text">Sistem Informasi<br><strong>Manajemen</strong></span>
    </div>
    
    <ul class="navbar-menu" id="navbarMenu">
      <li><a href="#hero" class="nav-link active">Home</a></li>
      <li><a href="#about" class="nav-link">Biodata</a></li>
      <li><a href="#featured-projects" class="nav-link">Proyek</a></li>
      <li><a href="#prestasi" class="nav-link">Prestasi & Sharing</a></li>
      <li><a href="#portfolio" class="nav-link">Portfolio</a></li>
      <li><a href="#contact" class="nav-link">Contact</a></li>
    </ul>
    
    <button type="button" class="mobile-menu-toggle" id="mobileToggle">
      <i class="bx bx-menu"></i>
    </button>
  </div>
</nav>

<!-- ======= Hero Section ======= -->
<section id="hero" class="hero-custom">
  <div class="container hero-grid">
    <div class="hero-text" data-aos="fade-right">
      <h1 class="simmy-title">Hi, I'm <strong>Rasya Nazhimah Marta Putri</strong></h1>
      <h2 class="simmy-sub">Programming Partner!</h2>
      <p class="simmy-desc">Passionate about creating innovative digital solutions and building meaningful web experiences.</p>
      <button class="btn btn-dark" onclick="document.querySelector('#contact').scrollIntoView({behavior:'smooth'});">
        Contact Me!
      </button>
    </div>
    
    <div class="hero-img" data-aos="fade-left">
      <img src="assets/img/canvas1.png" alt="canvs" class="simmy-image" />
    </div>
  </div>
</section>

<main id="main">

<!-- ======= About Section ======= -->
<section id="about" class="about section-padding">
  <div class="container">
    <div class="section-title" data-aos="fade-up">
      <h2>Want To Know More?</h2>
      <h3>About Me</h3>
    </div>

    <div class="about-card" data-aos="zoom-in">
      <!-- Dropdown Button -->
      <div class="about-dropdown-container">
        <button class="dropdown-toggle-custom" id="aboutDropdownBtn">
          <i class="bx bx-chevron-down"></i>
        </button>
        
        <div class="dropdown-menu-custom" id="aboutDropdownMenu">
          <a href="#about" class="dropdown-item-custom">
            <i class="bx bx-user"></i>
            <span>PROYEK</span>
          </a>
          <a href="#prestasi" class="dropdown-item-custom">
            <i class="bx bx-award"></i>
            <span>SERTIFIKAT & PENGALAMAN</span>
          </a>
          <a href="#portfolio" class="dropdown-item-custom">
            <i class="bx bx-share-alt"></i>
            <span>Sharing</span>
          </a>
          <a href="#contact" class="dropdown-item-custom">
            <i class="bx bx-envelope"></i>
            <span>KONTAK</span>
          </a>
        </div>
      </div>

      <div class="row align-items-center" id="about">
        <div class="col-lg-4 text-center">
          <div class="about-avatar">
            <img src="<?= h($profile['profile_image']) ?>" class="img-fluid" alt="<?= h($profile['full_name']) ?>">
          </div>
        </div>
        
        <div class="col-lg-8">
          <div class="about-content">
            <h3 class="about-name">Hello, I'm <?= h($profile['full_name']) ?></h3>
            <h4 class="about-role"><?= h($profile['title']) ?></h4>
            <p class="about-intro"><?= nl2br(h($profile['bio_short'])) ?></p>
            
            <div class="about-info">
              <div class="row">
                <div class="col-md-6 info-item">
                  <i class="bx bx-envelope"></i>
                  <strong>Email:</strong> <a href="mailto:<?= h($profile['email']) ?>"><?= h($profile['email']) ?></a>
                </div>
                <div class="col-md-6 info-item">
                  <i class="bx bx-phone"></i>
                  <strong>Mobile:</strong> <?= h($profile['phone']) ?>
                </div>
                <div class="col-md-6 info-item">
                  <i class="bx bx-map"></i>
                  <strong>Location:</strong> <?= h($profile['location']) ?>
                </div>
              </div>
            </div>
            
            <div class="about-buttons mt-4">
              <a href="cv.html" class="btn btn-dark me-3">CV Saya</a>
              <a href="about.php" class="btn btn-outline-secondary">Lihat Selengkapnya</a>  
            </div>
            
            <!-- Social Media Links -->
            <div class="about-social mt-4">
              <?php if ($profile['instagram']): ?>
                <a href="https://instagram.com/<?= h($profile['instagram']) ?>" target="_blank" class="social-link">
                  <i class='bx bxl-instagram'></i>
                </a>
              <?php endif; ?>
              
              <?php if ($profile['linkedin']): ?>
                <a href="https://linkedin.com/in/<?= h($profile['linkedin']) ?>" target="_blank" class="social-link">
                  <i class='bx bxl-linkedin'></i>
                </a>
              <?php endif; ?>
              
              <?php if ($profile['github']): ?>
                <a href="https://github.com/<?= h($profile['github']) ?>" target="_blank" class="social-link">
                  <i class='bx bxl-github'></i>
                </a>
              <?php endif; ?>
              
              <?php if ($profile['medium']): ?>
                <a href="https://medium.com/@<?= h($profile['medium']) ?>" target="_blank" class="social-link">
                  <i class='bx bxl-medium'></i>
                </a>
              <?php endif; ?>
              
              <?php if ($profile['threads']): ?>
                <a href="https://threads.net/@<?= h($profile['threads']) ?>" target="_blank" class="social-link">
                  <i class='bx bxl-meta'></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End About Section -->

<!-- Project -->
<section id="featured-projects" class="section-padding" style="background-color:#f8f9fa;">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <span style="color:#CEB068;font-weight:600;letter-spacing:1.5px;font-size:0.85rem;">MY EXPERTISE</span>
      <p style="margin-top:8px;font-weight:800;font-size:2.2rem;color:#1a1a1a;">Proyek Pilihan</p>
    </div>

    <?php foreach ($featured_projects as $i => $project): ?>
    <div class="project-card-wrapper mb-4" data-aos="zoom-in" <?= $i ? 'data-aos-delay="'.($i*100).'"' : '' ?>>
      <div class="project-card-overlay">
        <div class="project-image-container">
          <img src="<?= safe_image($project['project_image']) ?>" alt="Project" class="project-bg-image">
          <div class="project-overlay-gradient"></div>
          <div class="project-overlay-content">
            <div class="d-flex align-items-center mb-2">
              <img src="<?= h($profile['profile_image']) ?>" class="project-avatar">
              <span class="project-author"><?= h($profile['full_name']) ?></span>
              <?php if (!empty($project['category'])): ?>
                <span class="project-badge ml-auto"><?= h($project['category']) ?></span>
              <?php endif; ?>
            </div>
            <h5 class="project-title"><?= h($project['project_name']) ?></h5>
          </div>
        </div>
        <div class="project-bottom-section">
          <div class="project-question-box">
            <p>Penasaran dengan detail projectnya?</p>
          </div>
          <button class="project-arrow-btn" onclick="openProjectModal(<?= $project['id'] ?>)">
            <i class="bx bx-right-arrow-alt"></i>
          </button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="text-left mt-4" data-aos="fade-up">
      <a href="#portfolio" class="btn-lihat-selengkapnya">
        Lihat Selengkapnya
        <i class="bx bx-right-arrow-alt ml-2"></i>
      </a>
    </div>
  </div>

  <!-- Modal & Javascript for showing project details -->
  <div class="project-modal-overlay" id="projectModalOverlay" style="display:none" onclick="closeProjectModal()">
    <div class="project-modal-container" onclick="event.stopPropagation()">
      <button class="project-modal-close" onclick="closeProjectModal()"><i class="bx bx-arrow-back"></i></button>
      <div class="project-modal-content" id="projectModalContent"></div>
    </div>
  </div>
  <script>
  // Dynamic modal fetch from backend (AJAX)
  function openProjectModal(projectId) {
    $.get('project_detail_ajax.php', { id: projectId }, function(html) {
      $('#projectModalContent').html(html)
      $('#projectModalOverlay').show();
      document.body.style.overflow = 'hidden';
    });
  }
  function closeProjectModal() {
    $('#projectModalOverlay').hide();
    document.body.style.overflow = '';
  }
  </script>
</section>
<section id="prestasi" class="section-padding" style="background-color:#fff;">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <span style="color:#CEB068;font-weight:600;letter-spacing:1.5px;font-size:0.85rem;">MY WORK</span>
      <p style="margin-top:8px;font-weight:800;font-size:2.2rem;color:#1a1a1a;">Prestasi & Pengalaman</p>
      <p style="color:#6c757d;font-size:1.05rem;">Explore projects, certificates, and activities</p>
    </div>

    <!-- Achievement List -->
    <div class="achievement-list" data-aos="fade-up">
      <?php foreach ($all_certificates as $cert): ?>
      <?php
        $year = !empty($cert['issue_date']) ? date('Y', strtotime($cert['issue_date'])) : '';
      ?>
      <div class="achievement-item">
        <div class="achievement-content">
          <h4 class="achievement-title"><?= h($cert['certificate_title']) ?></h4>
          <div class="achievement-meta">
            <?php if ($year): ?>
              <span class="achievement-year"><?= h($year) ?></span>
              <span class="achievement-separator">-</span>
            <?php endif; ?>
            <span class="achievement-org"><?= h($cert['issuing_organization']) ?></span>
          </div>
        </div>
        <button class="achievement-arrow-btn" onclick="openAchievementModal(<?= $cert['id'] ?>)">
          <i class="bx bx-right-arrow-alt"></i>
        </button>
      </div>
      <?php endforeach; ?>

      <?php if (empty($all_certificates)): ?>
      <p class="text-center text-muted">Belum ada prestasi yang ditampilkan</p>
      <?php endif; ?>
    </div>


    <!-- Button Lihat Selengkapnya -->
    <div class="text-right mt-4" data-aos="fade-up">
      <a href="#portfolio" class="btn-lihat-selengkapnya">
        Lihat Selengkapnya
        <i class="bx bx-right-arrow-alt ml-2"></i>
      </a>
    </div>
  </div>

  <!-- Achievement Detail Modal -->
  <div class="achievement-modal-overlay" id="achievementModalOverlay" style="display:none" onclick="closeAchievementModal()">
    <div class="achievement-modal-container" onclick="event.stopPropagation()">
      <!-- Close/Back Button -->
      <button class="achievement-modal-close" onclick="closeAchievementModal()">
        <i class="bx bx-arrow-back"></i>
      </button>
      
      <div class="achievement-modal-content" id="achievementModalContent"></div>
    </div>
  </div>
</section>

<!-- Script untuk modal achievement -->
<script>
// Dynamic modal fetch from backend (AJAX)
function openAchievementModal(certificateId) {
  $.get('certificate_detail_ajax.php', { id: certificateId }, function(html) {
    $('#achievementModalContent').html(html);
    $('#achievementModalOverlay').css('display','flex');
    document.body.style.overflow = 'hidden';
  });
}

function closeAchievementModal() {
  $('#achievementModalOverlay').css('display','none');
  document.body.style.overflow = '';
}

// Close pada ESC key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeAchievementModal();
  }
});
</script>
<!-- ======= Sharing Section ======= -->
<section id="sharing" class="section-padding" style="background-color:#f8f9fa;">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <span style="color:#CEB068;font-weight:600;letter-spacing:1.5px;font-size:0.85rem;">MY WORK</span>
      <p style="margin-top:8px;font-weight:800;font-size:2.2rem;color:#1a1a1a;">Sharing</p>
      <p style="color:#6c757d;font-size:1.05rem;">Explore projects, certificates, and activities</p>
    </div>

    <!-- Carousel Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="carousel-dots" id="sharingDots"></div>
      <div class="carousel-nav-buttons">
        <button class="carousel-nav-btn prev" id="sharingPrev">
          <i class="bx bx-chevron-left"></i>
        </button>
        <button class="carousel-nav-btn next" id="sharingNext">
          <i class="bx bx-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Sharing Carousel Container -->
    <div class="sharing-carousel-wrapper">
      <div class="sharing-carousel" id="sharingCarousel">
        <?php if (!empty($sharing_content)): ?>
          <?php foreach ($sharing_content as $content): ?>
          <div class="sharing-card" style="min-width:320px;max-width:350px;background:white;border-radius:20px;box-shadow:0 2px 18px 3px #ececed;">
            <div class="sharing-card-image" style="position: relative;">
            <?php
              $sharingCategory = !empty($content['category']) ? $content['category'] : 'other';
              $badgeColor = getCategoryBadgeColor($sharingCategory);
            ?>
            <img src="<?= safe_image($content['content_image']) ?>" alt="<?= h($content['content_title']) ?>" class="img-fluid" style="border-radius:20px 20px 0 0; width:100%;">
            <span class="sharing-badge <?= h(strtolower($sharingCategory)) ?>" style="position:absolute;top:18px;left:18px;background:<?= h($badgeColor) ?>;color:#191919;font-weight:600;border-radius:8px;padding:4px 13px;font-size:0.92em;">
              <?= h(ucfirst($sharingCategory)) ?>
            </span>

            </div>
            <div class="sharing-card-content" style="padding:22px;">
              <div class="sharing-meta mb-2 d-flex align-items-center">
                <img src="<?= h($profile['profile_image']) ?>" class="sharing-avatar me-2" style="width:36px;height:36px;border-radius:50%;">
                <span class="sharing-time" style="font-size:0.88em;color:#b6b3b3;"><?= h($content['read_time']) ?></span>
              </div>
              <h4 class="sharing-title" style="font-size:1.1rem;font-weight:700;"><?= h($content['content_title']) ?></h4>
              <div style="color:#777;font-size:0.98em;margin-top:8px;">
                <?= h(substr($content['content_description'], 0, 200)) ?>...
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-muted">Belum ada konten sharing yang ditampilkan</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Script untuk Carousel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('sharingCarousel');
    const prevBtn = document.getElementById('sharingPrev');
    const nextBtn = document.getElementById('sharingNext');
    const dotsContainer = document.getElementById('sharingDots');
    
    if (!carousel) return;
    
    const cards = carousel.querySelectorAll('.sharing-card');
    const cardCount = cards.length;
    
    if (cardCount === 0) return;
    
    let currentIndex = 0;
    const cardWidth = 350; // max-width of card
    const gap = 20; // gap between cards
    
    // Create dots
    for (let i = 0; i < cardCount; i++) {
        const dot = document.createElement('span');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }
    
    const dots = dotsContainer.querySelectorAll('.carousel-dot');
    
    function updateCarousel() {
        const offset = currentIndex * (cardWidth + gap);
        carousel.style.transform = `translateX(-${offset}px)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
        
        // Update button states
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= cardCount - 1;
    }
    
    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, cardCount - 1));
        updateCarousel();
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentIndex < cardCount - 1) {
            currentIndex++;
            updateCarousel();
        }
    });
    
    // Initial update
    updateCarousel();
});
</script>
<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio section-bg section-padding">
  <div class="container">
    <div class="section-title" data-aos="fade-up">
      <h2>My Work</h2>
      <h3>Portfolio Showcase</h3>
      <p>Explore projects, certificates, and activities</p>
    </div>

    <!-- Portfolio Tabs -->
    <div class="portfolio-tabs" data-aos="fade-up">
      <button class="tab-btn active" data-filter="all">All</button>
      <button class="tab-btn" data-filter="projects">Projects</button>
      <button class="tab-btn" data-filter="certificates">Certificates</button>
      <button class="tab-btn" data-filter="sharing">Sharing</button>
    </div>

    <div class="row portfolio-grid">
      
      <!-- ========== PROJECTS ========== -->
      <?php foreach ($all_projects as $project): ?>
      <div class="col-lg-4 col-md-6 portfolio-item" data-category="projects" data-aos="zoom-in">
        <div class="portfolio-card">
          <div class="portfolio-img">
            <img src="<?= safe_image($project['project_image']) ?>" alt="<?= h($project['project_name']) ?>" class="portfolio-image" data-fallback="true">
            <div class="portfolio-overlay">
              <button class="portfolio-icon" onclick="openProjectModal(<?= $project['id'] ?>)">
                <i class="bx bx-show"></i>
              </button>
              <?php if ($project['project_url']): ?>
                <a href="<?= h($project['project_url']) ?>" target="_blank" class="portfolio-icon">
                  <i class="bx bx-link"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
          <div class="portfolio-info">
            <span class="portfolio-category">Projects</span>
            <h4><?= h($project['project_name']) ?></h4>
            <button class="portfolio-btn" onclick="openProjectModal(<?= $project['id'] ?>)">
              Details →
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- ========== CERTIFICATES ========== -->
      <?php foreach ($all_certificates as $cert): ?>
      <div class="col-lg-4 col-md-6 portfolio-item" data-category="certificates" data-aos="zoom-in">
        <div class="portfolio-card">
          <div class="portfolio-img">
            <img src="<?= safe_image($cert['certificate_image']) ?>" alt="<?= h($cert['certificate_title']) ?>" class="portfolio-image" data-fallback="true">
            <div class="portfolio-overlay">
              <button class="portfolio-icon eye-icon" onclick="openImageLightbox('<?= safe_image($cert['certificate_image']) ?>', '<?= h($cert['certificate_title']) ?>')">
                <i class="bx bx-show"></i>
              </button>
            </div>
          </div>
          <div class="portfolio-info">
            <span class="portfolio-category">Certificates</span>
            <h4><?= h($cert['certificate_title']) ?></h4>
            <button class="portfolio-btn" onclick="openImageLightbox('<?= h($cert['certificate_image']) ?>', '<?= h($cert['certificate_title']) ?>')">
              <i class="bx bx-show"></i> View
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- ========== SHARING CONTENT ========== -->
      <?php foreach ($all_sharing as $sharing): ?>
      <div class="col-lg-4 col-md-6 portfolio-item" data-category="sharing" data-aos="zoom-in">
        <div class="portfolio-card">
          <div class="portfolio-img">
            <img src="<?= safe_image($sharing['content_image']) ?>" alt="<?= h($sharing['content_title']) ?>" class="portfolio-image" data-fallback="true">
            <div class="portfolio-overlay">
              <button class="portfolio-icon" onclick="openSharingDetailModal(<?= $sharing['id'] ?>)">
                <i class="bx bx-show"></i>
              </button>
            </div>
          </div>
          <div class="portfolio-info">
            <span class="portfolio-category">Sharing</span>
            <h4><?= h($sharing['content_title']) ?></h4>
            <button class="portfolio-btn" onclick="openSharingDetailModal(<?= $sharing['id'] ?>)">
              Details →
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>

<!-- Image Lightbox Modal (untuk Certificates) -->
<div class="image-lightbox" id="imageLightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">
    <i class="bx bx-x"></i>
  </button>
  <div class="lightbox-content" onclick="event.stopPropagation()">
    <img id="lightboxImage" src="" alt="">
    <div class="lightbox-caption" id="lightboxCaption"></div>
  </div>
</div>

<!-- Sharing Detail Modal (untuk Sharing Content) -->
<div class="sharing-detail-modal" id="sharingDetailModal" onclick="closeSharingDetailModal()">
  <div class="sharing-detail-container" onclick="event.stopPropagation()">
    <button class="sharing-detail-close" onclick="closeSharingDetailModal()">
      <i class="bx bx-x"></i>
    </button>
    <div class="sharing-detail-content" id="sharingDetailContent"></div>
  </div>
</div>

<!-- Portfolio Filter & Modal Scripts -->
<script>
// Smart Image Fallback (prevent infinite loop)
document.addEventListener('DOMContentLoaded', function() {
    const portfolioImages = document.querySelectorAll('.portfolio-image[data-fallback="true"]');
    
    portfolioImages.forEach(img => {
        img.addEventListener('error', function() {
            // Hanya set fallback sekali, jangan loop
            if (this.src !== 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="300" height="300"%3E%3Crect fill="%23ddd" width="300" height="300"/%3E%3Ctext x="50%25" y="50%25" font-size="18" fill="%23999" text-anchor="middle" dy=".3em"%3EImage Not Found%3C/text%3E%3C/svg%3E') {
                this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="300" height="300"%3E%3Crect fill="%23ddd" width="300" height="300"/%3E%3Ctext x="50%25" y="50%25" font-size="18" fill="%23999" text-anchor="middle" dy=".3em"%3EImage Not Found%3C/text%3E%3C/svg%3E';
                this.removeAttribute('data-fallback');
            }
        });
    });
});

// Portfolio Filter Tabs
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.tab-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            portfolioItems.forEach(item => {
                if (filterValue === 'all') {
                    item.style.display = 'block';
                    setTimeout(() => item.style.opacity = '1', 10);
                } else {
                    if (item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => item.style.opacity = '1', 10);
                    } else {
                        item.style.opacity = '0';
                        setTimeout(() => item.style.display = 'none', 300);
                    }
                }
            });
        });
    });
});

// Image Lightbox (for Certificates)
function openImageLightbox(imageSrc, caption) {
    document.getElementById('lightboxImage').src = imageSrc;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('imageLightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('imageLightbox').style.display = 'none';
    document.body.style.overflow = '';
}

// Sharing Detail Modal (AJAX)
function openSharingDetailModal(sharingId) {
    $.get('sharing_detail_modal.php', { id: sharingId }, function(html) {
        $('#sharingDetailContent').html(html);
        $('#sharingDetailModal').css('display', 'flex');
        document.body.style.overflow = 'hidden';
    });
}

function closeSharingDetailModal() {
    $('#sharingDetailModal').css('display', 'none');
    document.body.style.overflow = '';
}

// Close modals on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
        closeSharingDetailModal();
    }
});
</script>

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact section-bg section-padding">
  <div class="container">
    <div class="section-title" data-aos="fade-up">
      <h2>Let's Connect</h2>
      <h3>Get in Touch</h3>
      <p>Have something to discuss? Send me a message and let's talk.</p>
    </div>

    <div class="row">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="contact-info-card">
          <h3>Contact Info</h3>
          
          <div class="contact-item">
            <div class="contact-icon"><i class="bx bx-map"></i></div>
            <div>
              <h4>Location:</h4>
              <p>Surabaya, East Java, Indonesia</p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="bx bx-envelope"></i></div>
            <div>
              <h4>Email:</h4>
              <p><a href="mailto:nazmiahrasya@gmail.com">nazmiahrasya@gmail.com</a></p>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class="bx bx-phone"></i></div>
            <div>
              <h4>Call:</h4>
              <p>+62 812-3456-7890</p>
            </div>
          </div>

          <div class="social-connect">
            <h4>Connect With Me</h4>
            <div class="social-links">
              <a href="https://linkedin.com/in/"><i class="bx bxl-linkedin"></i> LinkedIn</a>
              <a href="https://twitter.com/nazhimah.acha"><i class="bx bxl-twitter"></i> Twitter</a>
              <a href="https://instagram.com/biancaca.acha"><i class="bx bxl-instagram"></i> Instagram</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="contact-form-card">
          <h3>Send Message</h3>
          <form action="#" method="post" class="contact-form">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Name*</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
              </div>
              <div class="form-group col-md-6">
                <label>Email*</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
              </div>
            </div>
            
            <div class="form-group">
              <label>Message*</label>
              <textarea name="message" class="form-control" rows="6" placeholder="Write your message here..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">
              <i class="bx bx-send"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Footer Left -->
                <div class="footer-left">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">R</div>
                        <div class="footer-logo-text">Rasya</div>
                    </div>
                    <p class="footer-quote">
                        "Ketika kamu menginginkan sesuatu, segenap alam semesta 
                        akan bersatu padu membantumu meraihnya." - Paulo Coelho
                    </p>
                    <!-- Footer Social -->
                    <div class="footer-social">
                        <a href="https://facebook.com/rasya" target="_blank">
                            <i class='bx bxl-facebook'></i>
                        </a>
                        <a href="https://twitter.com/nazhimah.acha" target="_blank">
                            <i class='bx bxl-twitter'></i>
                        </a>
                        <a href="https://instagram.com/biancaca.acha" target="_blank">
                            <i class='bx bxl-instagram'></i>
                        </a>
                        <a href="https://linkedin.com/in/rasya" target="_blank">
                            <i class='bx bxl-linkedin'></i>
                        </a>
                    </div>
                </div>
                
                <!-- Footer Right -->
                <div class="footer-right">
                    <!-- Quick Links -->
                    <div class="footer-links">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="admin/login/index.php">Dashboard Admin</a></li>
                            <li><a href="about.html">About Me</a></li>
                            <li><a href="#project">Project</a></li>
                            <li><a href="#contact">Contact Me</a></li>
                        </ul>
                    </div>
                    
                    <!-- Other Links -->
                    <div class="footer-links">
                        <h6>Other</h6>
                        <ul>
                            <li><a href="#sharing">Sharing</a></li>
                            <li><a href="#">Footer</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; 2025 <a href="index.html">Rasya</a> All Rights Reserved , Inc.</p>
            </div>
        </div>
    </footer>

<a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

<!-- Portfolio Modal (untuk Projects & Sharing) -->
<div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content portfolio-modal-content">
      <button type="button" class="modal-close" data-dismiss="modal">
        <i class="bx bx-x"></i>
      </button>
      <div class="modal-body p-0">
        <div class="row no-gutters">
          <div class="col-lg-6">
            <div class="modal-image">
              <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="modal-details">
              <span class="modal-category" id="modalCategory"></span>
              <h2 id="modalTitle"></h2>
              <p class="modal-description">
                Innovative project showcasing modern development techniques and best practices.
              </p>
              <div class="modal-actions">
                <a id="modalLink" href="#" target="_blank" class="btn-modal-primary">
                  <i class="bx bx-link-external"></i> Visit Project
                </a>
                <button class="btn-modal-secondary" data-dismiss="modal">
                  <i class="bx bx-x"></i> Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Image Lightbox Modal (untuk Certificates) -->
<div class="modal fade" id="imageLightboxModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered" role="document">
    <div class="modal-content lightbox-modal-content">
      <button type="button" class="lightbox-close" data-dismiss="modal">
        <i class="bx bx-x"></i>
      </button>
      <div class="lightbox-body">
        <div class="lightbox-container">
          <img id="lightboxImage" src="" alt="" class="lightbox-image">
        </div>
        <div class="lightbox-info">
          <h3 id="lightboxTitle"></h3>
        </div>
      </div>
      
      <!-- Navigation arrows -->
      <button class="lightbox-nav prev" id="lightboxPrev">
        <i class="bx bx-chevron-left"></i>
      </button>
      <button class="lightbox-nav next" id="lightboxNext">
        <i class="bx bx-chevron-right"></i>
      </button>
    </div>
  </div>
</div>

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
