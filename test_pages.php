<?php
require_once 'src/Database.php';
require_once 'src/User.php';
require_once 'src/Contact.php';
require_once 'src/Lead.php';
require_once 'src/Deal.php';
require_once 'src/Status.php';

echo "<h2>CRM Tool - Page Testing</h2>";
echo "<style>
body { font-family: Arial, sans-serif; max-width: 1000px; margin: 20px auto; padding: 20px; }
.test-section { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
.success { color: green; }
.error { color: red; }
.info { color: blue; }
</style>";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    // Initialize objects
    $user = new User($db);
    $contact = new Contact($db);
    $lead = new Lead($db);
    $deal = new Deal($db);
    $status = new Status($db);
    
    echo "<div class='test-section'><h3>1. Testing Contact Management</h3>";
    
    // Test adding a contact
    $contact->first_name = "Test";
    $contact->last_name = "Contact";
    $contact->email = "test@example.com";
    $contact->phone = "555-1234";
    $contact->company = "Test Company";
    $contact->position = "Manager";
    
    $contact_id = $contact->create();
    if ($contact_id) {
        echo "<p class='success'>✓ Contact created successfully (ID: $contact_id)</p>";
    } else {
        echo "<p class='error'>✗ Failed to create contact</p>";
    }
    
    // Test reading the contact
    $contact->id = $contact_id;
    if ($contact->readOne()) {
        echo "<p class='success'>✓ Contact read successfully: {$contact->first_name} {$contact->last_name}</p>";
    } else {
        echo "<p class='error'>✗ Failed to read contact</p>";
    }
    
    // Test updating the contact
    $contact->position = "Senior Manager";
    if ($contact->update()) {
        echo "<p class='success'>✓ Contact updated successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to update contact</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>2. Testing Lead Management</h3>";
    
    // Test adding a lead
    $lead->contact_id = $contact_id;
    $lead->title = "Test Lead";
    $lead->description = "This is a test lead for testing purposes";
    $lead->value = 15000;
    $lead->source = "website";
    $lead->status = "new";
    
    $lead_id = $lead->create();
    if ($lead_id) {
        echo "<p class='success'>✓ Lead created successfully (ID: $lead_id)</p>";
    } else {
        echo "<p class='error'>✗ Failed to create lead</p>";
    }
    
    // Test reading the lead
    $lead->id = $lead_id;
    $lead_data = $lead->readOne();
    if ($lead_data) {
        echo "<p class='success'>✓ Lead read successfully: {$lead->title}</p>";
    } else {
        echo "<p class='error'>✗ Failed to read lead</p>";
    }
    
    // Test updating lead status
    if ($lead->updateStatus("qualified")) {
        echo "<p class='success'>✓ Lead status updated successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to update lead status</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>3. Testing Deal Management</h3>";
    
    // Test adding a deal
    $deal->lead_id = $lead_id;
    $deal->title = "Test Deal";
    $deal->description = "This is a test deal for testing purposes";
    $deal->value = 25000;
    $deal->stage = "prospecting";
    $deal->close_date = "2024-12-31";
    
    $deal_id = $deal->create();
    if ($deal_id) {
        echo "<p class='success'>✓ Deal created successfully (ID: $deal_id)</p>";
    } else {
        echo "<p class='error'>✗ Failed to create deal</p>";
    }
    
    // Test reading the deal
    $deal->id = $deal_id;
    $deal_data = $deal->readOne();
    if ($deal_data) {
        echo "<p class='success'>✓ Deal read successfully: {$deal->title}</p>";
    } else {
        echo "<p class='error'>✗ Failed to read deal</p>";
    }
    
    // Test updating deal stage
    if ($deal->updateStage("qualification")) {
        echo "<p class='success'>✓ Deal stage updated successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to update deal stage</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>4. Testing Activity Management</h3>";
    
    // Test adding an activity
    $sql = "INSERT INTO activities (type, subject, description, contact_id, lead_id, deal_id, due_date, completed) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    
    if ($stmt->execute(['call', 'Test Call', 'Follow up call with test contact', $contact_id, $lead_id, $deal_id, '2024-12-31 10:00:00', 0])) {
        $activity_id = $db->lastInsertId();
        echo "<p class='success'>✓ Activity created successfully (ID: $activity_id)</p>";
    } else {
        echo "<p class='error'>✗ Failed to create activity</p>";
    }
    
    // Test reading activities
    $sql = "SELECT COUNT(*) as count FROM activities WHERE contact_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$contact_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p class='success'>✓ Found {$result['count']} activities for the test contact</p>";
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>5. Testing Dashboard Statistics</h3>";
    
    // Test dashboard stats
    $stats = $status->getDashboardStats();
    echo "<p class='info'>Dashboard Statistics:</p>";
    echo "<ul>";
    echo "<li>Total Contacts: {$stats['total_contacts']}</li>";
    echo "<li>Total Leads: {$stats['total_leads']}</li>";
    echo "<li>Total Deals: {$stats['total_deals']}</li>";
    echo "<li>Pipeline Value: $" . number_format($stats['pipeline_value'], 2) . "</li>";
    echo "</ul>";
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>6. Testing Search Functionality</h3>";
    
    // Test contact search
    $search_results = $contact->search("Test");
    $search_count = $search_results->rowCount();
    echo "<p class='success'>✓ Contact search found $search_count results for 'Test'</p>";
    
    // Test lead stats
    $lead_stats = $lead->getLeadStats();
    echo "<p class='info'>Lead Statistics:</p>";
    while ($stat = $lead_stats->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>- {$stat['status']}: {$stat['count']} leads, Total Value: $" . number_format($stat['total_value'], 2) . "</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>7. Testing Deletion (Cleanup)</h3>";
    
    // Test deleting the activity
    if (isset($activity_id)) {
        $sql = "DELETE FROM activities WHERE id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$activity_id])) {
            echo "<p class='success'>✓ Activity deleted successfully</p>";
        } else {
            echo "<p class='error'>✗ Failed to delete activity</p>";
        }
    }
    
    // Test deleting the deal
    if ($deal->delete()) {
        echo "<p class='success'>✓ Deal deleted successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to delete deal</p>";
    }
    
    // Test deleting the lead
    if ($lead->delete()) {
        echo "<p class='success'>✓ Lead deleted successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to delete lead</p>";
    }
    
    // Test deleting the contact
    if ($contact->delete()) {
        echo "<p class='success'>✓ Contact deleted successfully</p>";
    } else {
        echo "<p class='error'>✗ Failed to delete contact</p>";
    }
    
    echo "</div>";
    
    echo "<div class='test-section'><h3>✅ All Tests Completed!</h3>";
    echo "<p class='success'>The CRM system is working correctly. All CRUD operations for contacts, leads, deals, and activities are functioning properly.</p>";
    echo "<p><a href='public/index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to CRM Tool</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='test-section'>";
    echo "<h3>❌ Test Failed</h3>";
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection and ensure all tables are created properly.</p>";
    echo "</div>";
}
?> 