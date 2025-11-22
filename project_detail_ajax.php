<?php
require_once 'includes/functions.php';
$id = intval($_GET['id']);
$project = getProjectById($id);
$profile = getProfile();
if (!$project) {
  echo "<p>Project tidak ditemukan.</p>";
  exit;
}
?>
<!-- LEFT: Image & Title -->
<div class="project-modal-image">
  <img src="<?= h($project['project_image']) ?>" alt="Project Detail">
</div>

<!-- RIGHT: Description -->
<div class="project-modal-details">
  <div class="project-modal-header">
    <h2><?= h($project['project_name']) ?></h2>
    <span class="project-modal-category"><?= h($project['category']) ?></span>
  </div>
  <div class="project-modal-description">
    <p><?= nl2br(h($project['full_description'])) ?></p>
    <div class="project-modal-meta">
      <div class="meta-item"><i class="bx bx-calendar"></i>
        <span><?= date('F Y', strtotime($project['start_date'] ?? $project['created_at'])) ?></span>
      </div>
      <div class="meta-item"><i class="bx bx-user"></i><span><?= h($profile['full_name']) ?></span></div>
      <div class="meta-item"><i class="bx bx-time"></i>
        <span><?= h(calculateDuration($project['start_date'], $project['end_date'])) ?></span>
      </div>
    </div>
    <div class="project-modal-tags">
      <?php foreach (explode(',', $project['technologies']) as $tech): ?>
        <span class="project-tag"><?= h(trim($tech)) ?></span>
      <?php endforeach; ?>
    </div>
    <?php if ($project['project_url']): ?>
      <div class="mt-2">
        <a href="<?= h($project['project_url']) ?>" class="btn btn-primary" target="_blank">Lihat Project &rarr;</a>
      </div>
    <?php endif; ?>
  </div>
</div>
