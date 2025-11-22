<?php
/**
 * Generate Password Hash
 * File: generate_password.php
 * 
 * HAPUS FILE INI SETELAH SELESAI!
 */

if (isset($_GET['password'])) {
    $password = $_GET['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    echo "<h2>Password Hash Generator</h2>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
    echo "<p><strong>Hash:</strong></p>";
    echo "<textarea style='width:100%;height:100px;font-family:monospace;'>" . $hash . "</textarea>";
    echo "<br><br>";
    echo "<p>Copy hash di atas dan paste ke SQL INSERT statement.</p>";
} else {
    echo "<h2>Password Hash Generator</h2>";
    echo "<form method='get'>";
    echo "<label>Password: <input type='text' name='password' required></label><br><br>";
    echo "<button type='submit'>Generate Hash</button>";
    echo "</form>";
}
?>
