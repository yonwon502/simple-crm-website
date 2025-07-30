<?php
require_once 'src/Database.php';
require_once 'src/User.php';

echo "<h2>CRM Tool Setup</h2>";

try {
    // Create database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
        
        // Create tables
        if ($database->createTables()) {
            echo "<p style='color: green;'>✓ Database tables created successfully</p>";
            
            // Create default admin user
            $user = new User($db);
            
            // Check if admin user already exists
            $query = "SELECT COUNT(*) as count FROM users WHERE username = 'admin'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row['count'] == 0) {
                $user->username = 'admin';
                $user->email = 'admin@crmtool.com';
                $user->password = 'admin123';
                $user->role = 'admin';
                
                if ($user->create()) {
                    echo "<p style='color: green;'>✓ Default admin user created successfully</p>";
                    echo "<p><strong>Default Login Credentials:</strong></p>";
                    echo "<ul>";
                    echo "<li><strong>Username:</strong> admin</li>";
                    echo "<li><strong>Password:</strong> admin123</li>";
                    echo "</ul>";
                } else {
                    echo "<p style='color: red;'>✗ Error creating admin user</p>";
                }
            } else {
                echo "<p style='color: blue;'>ℹ Admin user already exists</p>";
            }
            
            // Create some sample data
            $this->createSampleData($db);
            
            echo "<p style='color: green;'>✓ Setup completed successfully!</p>";
            echo "<p><a href='public/index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to CRM Tool</a></p>";
            
        } else {
            echo "<p style='color: red;'>✗ Error creating database tables</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
        echo "<p>Please check your database configuration in src/Database.php</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Setup failed: " . $e->getMessage() . "</p>";
}

function createSampleData($db) {
    try {
        // Create sample contacts
        $contacts = [
            ['John', 'Doe', 'john.doe@example.com', '555-0101', 'TechCorp', 'CEO'],
            ['Jane', 'Smith', 'jane.smith@example.com', '555-0102', 'InnovateInc', 'CTO'],
            ['Mike', 'Johnson', 'mike.johnson@example.com', '555-0103', 'StartupXYZ', 'Founder'],
            ['Sarah', 'Williams', 'sarah.williams@example.com', '555-0104', 'GlobalTech', 'VP Sales'],
            ['David', 'Brown', 'david.brown@example.com', '555-0105', 'FutureSoft', 'Manager']
        ];
        
        $contact_query = "INSERT INTO contacts (first_name, last_name, email, phone, company, position) VALUES (?, ?, ?, ?, ?, ?)";
        $contact_stmt = $db->prepare($contact_query);
        
        foreach ($contacts as $contact) {
            $contact_stmt->execute($contact);
        }
        
        // Create sample leads
        $leads = [
            ['Website Redesign Project', 'Looking for a complete website redesign', 15000, 'website', 'new'],
            ['Mobile App Development', 'Need a mobile app for our business', 25000, 'referral', 'contacted'],
            ['Cloud Migration', 'Moving our infrastructure to cloud', 50000, 'cold_call', 'qualified'],
            ['Security Audit', 'Comprehensive security assessment needed', 12000, 'social_media', 'proposal'],
            ['Training Program', 'Employee training program development', 8000, 'other', 'negotiation']
        ];
        
        $lead_query = "INSERT INTO leads (title, description, value, source, status) VALUES (?, ?, ?, ?, ?)";
        $lead_stmt = $db->prepare($lead_query);
        
        foreach ($leads as $lead) {
            $lead_stmt->execute($lead);
        }
        
        // Create sample deals
        $deals = [
            ['Enterprise Software License', 'Annual software license for 500 users', 75000, 'prospecting', '2024-12-31'],
            ['Consulting Services', '6-month consulting engagement', 45000, 'qualification', '2024-11-30'],
            ['Hardware Purchase', 'Server infrastructure upgrade', 120000, 'proposal', '2024-10-15'],
            ['Training Contract', 'Year-long training program', 35000, 'negotiation', '2024-09-30'],
            ['Support Agreement', 'Premium support package', 25000, 'closed_won', '2024-08-31']
        ];
        
        $deal_query = "INSERT INTO deals (title, description, value, stage, close_date) VALUES (?, ?, ?, ?, ?)";
        $deal_stmt = $db->prepare($deal_query);
        
        foreach ($deals as $deal) {
            $deal_stmt->execute($deal);
        }
        
        echo "<p style='color: green;'>✓ Sample data created successfully</p>";
        
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠ Sample data creation failed: " . $e->getMessage() . "</p>";
    }
}
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

ul {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    border-left: 4px solid #3498db;
}

a {
    display: inline-block;
    margin-top: 20px;
}
</style> 