<?php
require_once 'includes/functions.php';
$id = intval($_GET['id']);
$sharing = getSharingById($id);
$profile = getProfile();

if (!$sharing) {
    echo "<p>Content tidak ditemukan.</p>";
    exit;
}
?>
<img src="<?= h($sharing['content_image']) ?>" alt="<?= h($sharing['content_title']) ?>">
<div style="margin-top: 20px;">
    <span style="display: inline-block; background: <?= getCategoryBadgeColor($sharing['category']) ?>; color: #1a1a1a; padding: 6px 14px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">
        <?= h(ucfirst($sharing['category'])) ?>
    </span>
    <h3><?= h($sharing['content_title']) ?></h3>
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; color: #666;">
        <img src="<?= h($profile['profile_image']) ?>" style="width: 30px; height: 30px; border-radius: 50%;">
        <span><?= h($profile['full_name']) ?></span>
        <span>•</span>
        <span><?= h($sharing['read_time']) ?></span>
        <span>•</span>
        <span><?= date('d M Y', strtotime($sharing['published_date'])) ?></span>
    </div>
    <p style="line-height: 1.8; color: #555;">
        <?= nl2br(h($sharing['content_description'])) ?>
    </p>
</div>
