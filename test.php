<?php
echo "<h1>CRM Tool - Basic Test</h1>";
echo "<p>If you can see this, PHP and Apache are working correctly!</p>";

echo "<h2>System Information</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Current File:</strong> " . __FILE__ . "</p>";

echo "<h2>Quick Links</h2>";
echo "<ul>";
echo "<li><a href='setup.php'>Setup CRM Tool</a></li>";
echo "<li><a href='path_check.php'>Check File Paths</a></li>";
echo "<li><a href='check_ports.php'>Check Ports</a></li>";
echo "<li><a href='debug.php'>Debug Information</a></li>";
echo "</ul>";

echo "<h2>Directory Contents</h2>";
$files = scandir(__DIR__);
echo "<ul>";
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_path = __DIR__ . '/' . $file;
        if (is_dir($file_path)) {
            echo "<li><strong>$file/</strong> (directory)</li>";
        } else {
            echo "<li>$file (file)</li>";
        }
    }
}
echo "</ul>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f8f9fa;
}

h1, h2 {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

p {
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    background-color: white;
}

ul {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    border-left: 4px solid #3498db;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

strong {
    color: #2c3e50;
}
</style> 