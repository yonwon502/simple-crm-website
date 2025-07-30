<?php
echo "<h2>File Path and Location Check</h2>";

// Check current file location
echo "<h3>Current File Information</h3>";
echo "<p><strong>Current file:</strong> " . __FILE__ . "</p>";
echo "<p><strong>Current directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Document root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "</p>";
echo "<p><strong>Script name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "</p>";

// Check if we're in the correct location
$expected_path = 'C:\\xampp\\htdocs\\crm_tool';
$current_path = __DIR__;

if (strcasecmp($current_path, $expected_path) === 0) {
    echo "<p style='color: green;'>✓ Files are in the correct XAMPP htdocs location</p>";
} else {
    echo "<p style='color: red;'>✗ Files are NOT in the expected XAMPP location</p>";
    echo "<p><strong>Expected:</strong> $expected_path</p>";
    echo "<p><strong>Current:</strong> $current_path</p>";
}

// Check if key files exist
echo "<h3>File Existence Check</h3>";
$required_files = [
    'setup.php',
    'src/Database.php',
    'src/User.php',
    'public/index.php'
];

foreach ($required_files as $file) {
    $full_path = __DIR__ . '/' . $file;
    if (file_exists($full_path)) {
        echo "<p style='color: green;'>✓ $file exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $file is missing</p>";
        echo "<p><strong>Expected path:</strong> $full_path</p>";
    }
}

// Check directory structure
echo "<h3>Directory Structure</h3>";
$directories = [
    'src',
    'public',
    'assets'
];

foreach ($directories as $dir) {
    $full_path = __DIR__ . '/' . $dir;
    if (is_dir($full_path)) {
        echo "<p style='color: green;'>✓ $dir/ directory exists</p>";
        
        // List files in directory
        $files = scandir($full_path);
        echo "<p><strong>Files in $dir/:</strong></p>";
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li>$file</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>✗ $dir/ directory is missing</p>";
    }
}

// Check XAMPP htdocs directory
echo "<h3>XAMPP htdocs Check</h3>";
$xampp_htdocs = 'C:\\xampp\\htdocs';
if (is_dir($xampp_htdocs)) {
    echo "<p style='color: green;'>✓ XAMPP htdocs directory exists</p>";
    
    // Check if crm_tool is in htdocs
    $crm_in_htdocs = $xampp_htdocs . '\\crm_tool';
    if (is_dir($crm_in_htdocs)) {
        echo "<p style='color: green;'>✓ crm_tool directory found in htdocs</p>";
    } else {
        echo "<p style='color: red;'>✗ crm_tool directory NOT found in htdocs</p>";
        echo "<p><strong>Expected:</strong> $crm_in_htdocs</p>";
    }
    
    // List contents of htdocs
    echo "<p><strong>Contents of htdocs:</strong></p>";
    $htdocs_contents = scandir($xampp_htdocs);
    echo "<ul>";
    foreach ($htdocs_contents as $item) {
        if ($item != '.' && $item != '..') {
            $item_path = $xampp_htdocs . '\\' . $item;
            if (is_dir($item_path)) {
                echo "<li><strong>$item/</strong> (directory)</li>";
            } else {
                echo "<li>$item (file)</li>";
            }
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>✗ XAMPP htdocs directory not found</p>";
    echo "<p><strong>Expected:</strong> $xampp_htdocs</p>";
}

// Check URL accessibility
echo "<h3>URL Accessibility Test</h3>";
$test_urls = [
    'http://localhost/crm_tool/path_check.php',
    'http://localhost/crm_tool/setup.php',
    'http://localhost/crm_tool/public/index.php'
];

foreach ($test_urls as $url) {
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "<p style='color: green;'>✓ $url is accessible</p>";
    } else {
        echo "<p style='color: red;'>✗ $url is NOT accessible</p>";
    }
}

echo "<h3>Solution Steps</h3>";
echo "<ol>";
echo "<li>Make sure all CRM tool files are in: <strong>C:\\xampp\\htdocs\\crm_tool\\</strong></li>";
echo "<li>Check that the directory structure is correct</li>";
echo "<li>Verify file permissions (should be readable by Apache)</li>";
echo "<li>Try accessing: <a href='http://localhost/crm_tool/setup.php'>http://localhost/crm_tool/setup.php</a></li>";
echo "</ol>";

echo "<h3>Quick Fix</h3>";
echo "<p>If files are in the wrong location, copy them to: <strong>C:\\xampp\\htdocs\\crm_tool\\</strong></p>";
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

strong {
    color: #2c3e50;
}
</style> 