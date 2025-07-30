<?php
echo "<h2>CRM Tool Setup Test</h2>";

// Test basic PHP functionality
echo "<p style='color: green;'>✓ PHP is working</p>";

// Test file includes
try {
    require_once 'src/Database.php';
    echo "<p style='color: green;'>✓ Database.php loaded successfully</p>";
    
    require_once 'src/User.php';
    echo "<p style='color: green;'>✓ User.php loaded successfully</p>";
    
    // Test database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
        
        // Test table creation
        if ($database->createTables()) {
            echo "<p style='color: green;'>✓ Tables created successfully</p>";
            
            // Test user creation
            $user = new User($db);
            $user->username = 'test_admin';
            $user->email = 'test@crmtool.com';
            $user->password = 'test123';
            $user->role = 'admin';
            
            if ($user->create()) {
                echo "<p style='color: green;'>✓ Test user created successfully</p>";
                
                // Clean up test user
                $delete_query = "DELETE FROM users WHERE username = 'test_admin'";
                $db->exec($delete_query);
                echo "<p style='color: blue;'>ℹ Test user cleaned up</p>";
            } else {
                echo "<p style='color: red;'>✗ Error creating test user</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Error creating tables</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='setup.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Run Full Setup</a></p>";
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