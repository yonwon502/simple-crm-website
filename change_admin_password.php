<?php
require_once 'src/Database.php';
require_once 'src/User.php';

echo "<h2>Change Admin Password</h2>";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['new_username'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($new_username)) {
        $errors[] = "Username is required";
    } elseif (strlen($new_username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }
    
    if (empty($new_password)) {
        $errors[] = "Password is required";
    } elseif (strlen($new_password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        $errors[] = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&)";
    }
    
    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    if (empty($errors)) {
        try {
            $database = new Database();
            $db = $database->getConnection();
            
            if ($db) {
                // Find the admin user
                $query = "SELECT id FROM users WHERE username = 'admin'";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $admin_user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($admin_user) {
                    $user = new User($db);
                    $user->id = $admin_user['id'];
                    
                    // Update username and password
                    $update_query = "UPDATE users SET username = ?, password = ? WHERE id = ?";
                    $update_stmt = $db->prepare($update_query);
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    if ($update_stmt->execute([$new_username, $hashed_password, $admin_user['id']])) {
                        echo "<p style='color: green;'>✓ Admin credentials updated successfully!</p>";
                        echo "<p><strong>New Login Credentials:</strong></p>";
                        echo "<ul>";
                        echo "<li><strong>Username:</strong> " . htmlspecialchars($new_username) . "</li>";
                        echo "<li><strong>Password:</strong> " . str_repeat('*', strlen($new_password)) . "</li>";
                        echo "</ul>";
                        echo "<p><a href='public/index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to CRM Tool</a></p>";
                    } else {
                        echo "<p style='color: red;'>✗ Error updating admin credentials</p>";
                    }
                } else {
                    echo "<p style='color: red;'>✗ Admin user not found. Please run setup.php first.</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Database connection failed</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Please fix the following errors:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    }
}
?>

<form method="POST" style="max-width: 400px; margin: 20px 0;">
    <div style="margin-bottom: 15px;">
        <label for="new_username" style="display: block; margin-bottom: 5px; font-weight: bold;">New Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo htmlspecialchars($_POST['new_username'] ?? ''); ?>" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="new_password" style="display: block; margin-bottom: 5px; font-weight: bold;">New Password:</label>
        <input type="password" id="new_password" name="new_password" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required minlength="8">
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            Password must be at least 8 characters and contain uppercase, lowercase, number, and special character (@$!%*?&).
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="confirm_password" style="display: block; margin-bottom: 5px; font-weight: bold;">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" 
               style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
    </div>
    
    <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
        Update Admin Credentials
    </button>
</form>

<p style="color: #666; font-size: 14px;">
    <strong>Note:</strong> This will change the default admin credentials (admin/admin123) to your new credentials.
    Make sure to remember your new username and password!
</p>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 600px;
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

ul {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    border-left: 4px solid #3498db;
}

form {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

button:hover {
    background: #218838 !important;
}

a {
    display: inline-block;
    margin-top: 20px;
}
</style> 