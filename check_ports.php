<?php
echo "<h2>Port and Service Check</h2>";

// Check common ports used by XAMPP
$ports = [
    80 => 'HTTP (Apache)',
    443 => 'HTTPS (Apache SSL)',
    3306 => 'MySQL',
    3307 => 'MySQL (Alternative)',
    8080 => 'HTTP (Alternative)',
    8443 => 'HTTPS (Alternative)'
];

echo "<h3>Port Status Check</h3>";
foreach ($ports as $port => $service) {
    $connection = @fsockopen('localhost', $port, $errno, $errstr, 5);
    if (is_resource($connection)) {
        echo "<p style='color: green;'>✓ Port $port ($service) is in use</p>";
        fclose($connection);
    } else {
        echo "<p style='color: red;'>✗ Port $port ($service) is not in use</p>";
    }
}

// Check XAMPP services
echo "<h3>XAMPP Service Check</h3>";

// Check if Apache is running
$apache_check = @fsockopen('localhost', 80, $errno, $errstr, 5);
if (is_resource($apache_check)) {
    echo "<p style='color: green;'>✓ Apache is running on port 80</p>";
    fclose($apache_check);
} else {
    echo "<p style='color: red;'>✗ Apache is not running on port 80</p>";
}

// Check if MySQL is running
$mysql_check = @fsockopen('localhost', 3306, $errno, $errstr, 5);
if (is_resource($mysql_check)) {
    echo "<p style='color: green;'>✓ MySQL is running on port 3306</p>";
    fclose($mysql_check);
} else {
    echo "<p style='color: red;'>✗ MySQL is not running on port 3306</p>";
}

// Check XAMPP Control Panel
echo "<h3>XAMPP Configuration</h3>";
echo "<p><strong>Common XAMPP paths:</strong></p>";
$xampp_paths = [
    'C:\\xampp\\apache\\conf\\httpd.conf',
    'C:\\xampp\\mysql\\bin\\mysql.exe',
    'C:\\xampp\\php\\php.ini'
];

foreach ($xampp_paths as $path) {
    if (file_exists($path)) {
        echo "<p style='color: green;'>✓ $path exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $path not found</p>";
    }
}

// Check current URL and server info
echo "<h3>Current Server Information</h3>";
echo "<p><strong>Server Name:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'Not set') . "</p>";
echo "<p><strong>Server Port:</strong> " . ($_SERVER['SERVER_PORT'] ?? 'Not set') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "</p>";
echo "<p><strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "</p>";

// Test database connection with different ports
echo "<h3>Database Connection Test</h3>";
try {
    require_once 'src/Database.php';
    
    // Test default port 3306
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p style='color: green;'>✓ Database connection successful on default port</p>";
    } else {
        echo "<p style='color: red;'>✗ Database connection failed on default port</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

// Check for common port conflicts
echo "<h3>Common Port Conflicts</h3>";
$conflict_checks = [
    'IIS' => 'Check if IIS is running on port 80',
    'Skype' => 'Skype sometimes uses port 80',
    'Other MySQL' => 'Check if another MySQL instance is running',
    'Other Apache' => 'Check if another web server is running'
];

foreach ($conflict_checks as $service => $check) {
    echo "<p><strong>$service:</strong> $check</p>";
}

echo "<h3>Troubleshooting Steps</h3>";
echo "<ol>";
echo "<li>Open XAMPP Control Panel</li>";
echo "<li>Stop Apache and MySQL if they're running</li>";
echo "<li>Check if any other services are using ports 80 or 3306</li>";
echo "<li>Start Apache and MySQL again</li>";
echo "<li>Try accessing <a href='http://localhost/crm_tool/setup.php'>setup.php</a></li>";
echo "</ol>";

echo "<p><strong>Alternative URLs to try:</strong></p>";
echo "<ul>";
echo "<li><a href='http://localhost:80/crm_tool/setup.php'>http://localhost:80/crm_tool/setup.php</a></li>";
echo "<li><a href='http://127.0.0.1/crm_tool/setup.php'>http://127.0.0.1/crm_tool/setup.php</a></li>";
echo "<li><a href='http://localhost:8080/crm_tool/setup.php'>http://localhost:8080/crm_tool/setup.php</a> (if Apache is on port 8080)</li>";
echo "</ul>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f8f9fa;
}

h2, h3 {
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

ol, ul {
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
</style> 