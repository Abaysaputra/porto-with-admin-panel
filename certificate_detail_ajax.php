<?php
require_once __DIR__ . '/includes/functions.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$certificate = $id > 0 ? getCertificateById($id) : null;
$profile = getProfile();

if (!$certificate) {
    echo "<p>Certificate tidak ditemukan.</p>";
    exit;
}

// ===== Helper kecil untuk image =====
function cert_safe_image($path) {
    return h(!empty($path) ? $path : 'assets/img/placeholder.jpg');
}

// ===== Handle tanggal =====
$issueDate  = $certificate['issue_date'] ?? null;
$yearLabel  = '';
$dateLabel  = '';

if (!empty($issueDate) && $issueDate !== '0000-00-00') {
    $yearLabel = date('Y', strtotime($issueDate));

    if (function_exists('formatCertificateDate')) {
        $dateLabel = formatCertificateDate($issueDate);
    } else {
        $dateLabel = date('d M Y', strtotime($issueDate));
    }
}

// Category & featured
$category   = !empty($certificate['category']) ? $certificate['category'] : 'other';
$isFeatured = !empty($certificate['is_featured']);
?>

<!-- LEFT: Certificate Image -->
<div class="achievement-modal-image">
  <img src="<?= cert_safe_image($certificate['certificate_image']) ?>" 
       alt="<?= h($certificate['certificate_title']) ?>">
</div>

<!-- RIGHT: Details -->
<div class="achievement-modal-details">
  <div class="achievement-modal-header">
    <div class="badge badge-secondary" style="margin-bottom:6px;">
      <?= h(ucfirst($category)) ?>
      <?php if ($isFeatured): ?>
        <span class="badge badge-warning ml-2">Featured</span>
      <?php endif; ?>
    </div>

    <div class="d-flex align-items-center justify-content-between">
      <h2><?= h($certificate['certificate_title']) ?></h2>
      <?php if ($yearLabel): ?>
        <span class="achievement-modal-year"><?= h($yearLabel) ?></span>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="achievement-modal-description">
    <?php if (!empty($certificate['issuing_organization'])): ?>
    <div class="achievement-modal-org">
      <i class="bx bx-building"></i>
      <span><?= h($certificate['issuing_organization']) ?></span>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($certificate['description'])): ?>
      <p><?= nl2br(h($certificate['description'])) ?></p>
    <?php endif; ?>
    
    <div class="achievement-modal-meta">
      <?php if ($dateLabel): ?>
      <div class="meta-item">
        <i class="bx bx-calendar"></i>
        <span><?= h($dateLabel) ?></span>
      </div>
      <?php endif; ?>

      <div class="meta-item">
        <i class="bx bx-award"></i>
        <span><?= h(ucfirst($category)) ?></span>
      </div>

      <?php if (!empty($certificate['credential_id'])): ?>
      <div class="meta-item">
        <i class="bx bx-id-card"></i>
        <span><?= h($certificate['credential_id']) ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>
  
  <?php if (!empty($certificate['credential_url'])): ?>
  <div class="achievement-modal-footer">
    <a href="<?= h($certificate['credential_url']) ?>" class="btn-achievement-cert" target="_blank">
      <i class="bx bx-link-external"></i> View Certificate
    </a>
  </div>
  <?php endif; ?>
</div>
