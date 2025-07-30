<?php
echo "<h2>Debug Information</h2>";

echo "<p><strong>Current file:</strong> " . __FILE__ . "</p>";
echo "<p><strong>PHP version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Current directory:</strong> " . getcwd() . "</p>";

// Test if we can read the setup file
$setup_file = __DIR__ . '/setup.php';
if (file_exists($setup_file)) {
    echo "<p style='color: green;'>✓ setup.php file exists</p>";
    
    // Read the first few lines to check for $this
    $content = file_get_contents($setup_file);
    if (strpos($content, '$this') !== false) {
        echo "<p style='color: red;'>✗ setup.php contains \$this</p>";
        // Find the line with $this
        $lines = explode("\n", $content);
        foreach ($lines as $line_num => $line) {
            if (strpos($line, '$this') !== false) {
                echo "<p style='color: red;'>Line " . ($line_num + 1) . ": " . htmlspecialchars($line) . "</p>";
            }
        }
    } else {
        echo "<p style='color: green;'>✓ setup.php does not contain \$this</p>";
    }
} else {
    echo "<p style='color: red;'>✗ setup.php file not found</p>";
}

// Test database connection
try {
    require_once 'src/Database.php';
    echo "<p style='color: green;'>✓ Database.php loaded</p>";
    
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='setup.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Try Setup Again</a></p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f8f9fa;
}

h2 {
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

a {
    display: inline-block;
    margin-top: 20px;
}
</style> 