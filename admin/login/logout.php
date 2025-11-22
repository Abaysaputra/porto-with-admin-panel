<?php
/**
 * Logout Handler
 * File: admin/login/logout.php
 */

require_once '../../includes/auth.php';

logoutUser();

header('Location: index.php?msg=logout');
exit;
?>
