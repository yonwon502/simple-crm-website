# CRM Tool - Customer Relationship Management System

A modern, feature-rich CRM system built with PHP, MySQL, and Bootstrap. This tool helps businesses manage their customer relationships, track leads, manage deals, and monitor sales activities.

## Features

### 🎯 Core Features
- **Contact Management** - Store and manage customer contact information
- **Lead Management** - Track potential customers through the sales funnel
- **Deal Pipeline** - Manage sales opportunities and track deal stages
- **Activity Tracking** - Log calls, emails, meetings, and tasks
- **User Management** - Role-based access control (Admin, Manager, Sales)
- **Dashboard Analytics** - Visual charts and statistics
- **Search & Filter** - Find contacts, leads, and deals quickly

### 📊 Dashboard Features
- Real-time statistics and metrics
- Sales pipeline visualization
- Lead source analysis
- Recent activity feed
- Upcoming tasks reminder
- Quick action buttons

### 🔐 Security Features
- Secure user authentication
- Password hashing
- Session management
- Role-based permissions
- SQL injection protection
- XSS protection

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **UI Framework**: Bootstrap 5.3
- **Charts**: Chart.js
- **Icons**: Font Awesome 6.4

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- PHP extensions: PDO, PDO_MySQL

### Step 1: Database Setup
1. Create a new MySQL database named `crm_tool`
2. Create a MySQL user with access to the database
3. Update database credentials in `src/Database.php`:
   ```php
   private $host = 'localhost';
   private $db_name = 'crm_tool';
   private $username = 'your_username';
   private $password = 'your_password';
   ```

### Step 2: File Setup
1. Upload all files to your web server
2. Ensure the web server has read/write permissions
3. Make sure the `public/` directory is accessible via web

### Step 3: Run Setup
1. Navigate to `http://your-domain.com/crm_tool/setup.php`
2. The setup script will:
   - Test database connection
   - Create all necessary tables
   - Create default admin user
   - Add sample data

### Step 4: Access the CRM
1. Go to `http://your-domain.com/crm_tool/public/`
2. Login with default credentials:
   - **Username**: admin
   - **Password**: admin123

## Database Structure

### Tables
- **users** - User accounts and authentication
- **contacts** - Customer contact information
- **leads** - Potential customers and opportunities
- **deals** - Sales opportunities and pipeline
- **activities** - Logged activities and tasks

### Relationships
- Contacts can have multiple leads
- Leads can convert to deals
- Activities can be linked to contacts, leads, or deals
- Users can be assigned to leads and deals

## Usage Guide

### Managing Contacts
1. Navigate to Contacts section
2. Add new contacts with complete information
3. Search and filter contacts
4. View, edit, or delete contact records
5. Link contacts to leads and deals

### Managing Leads
1. Go to Leads section
2. Create new leads from contacts
3. Track lead status through the pipeline
4. Assign leads to team members
5. Convert qualified leads to deals

### Managing Deals
1. Access Deals section
2. Create deals from leads
3. Track deal stages and values
4. Set close dates and assign owners
5. Monitor pipeline value and conversion rates

### Tracking Activities
1. Use Activities section
2. Log calls, emails, meetings, and tasks
3. Set due dates and reminders
4. Link activities to contacts, leads, or deals
5. Mark activities as completed

## User Roles

### Admin
- Full system access
- User management
- System configuration
- All CRUD operations

### Manager
- Team management
- Lead and deal assignment
- Activity monitoring
- Limited user management

### Sales Representative
- Contact management
- Lead and deal tracking
- Activity logging
- Personal dashboard

## Customization

### Styling
- Modify CSS variables in `public/index.php`
- Update color schemes and branding
- Customize card layouts and animations

### Database
- Add new fields to existing tables
- Create additional tables for custom features
- Modify relationships as needed

### Features
- Extend PHP classes for additional functionality
- Add new pages and sections
- Integrate with external APIs

## Security Best Practices

1. **Change Default Credentials**
   - Update admin password after first login
   - Create additional users with appropriate roles
   - Remove or secure setup.php after installation

2. **Database Security**
   - Use strong database passwords
   - Limit database user permissions
   - Regular database backups

3. **Server Security**
   - Keep PHP and MySQL updated
   - Use HTTPS in production
   - Configure proper file permissions

## Troubleshooting

### Common Issues

**Database Connection Error**
- Verify database credentials in `src/Database.php`
- Ensure MySQL service is running
- Check database user permissions

**Setup Page Not Working**
- Verify PHP PDO extension is installed
- Check file permissions
- Review error logs

**Login Issues**
- Clear browser cache and cookies
- Verify session configuration
- Check PHP session settings

### Error Logs
- Check PHP error logs for detailed error messages
- Review MySQL error logs for database issues
- Monitor web server access logs

## Support

For issues and questions:
1. Check the troubleshooting section
2. Review PHP and MySQL documentation
3. Verify server requirements
4. Test with sample data

## License

This CRM tool is provided as-is for educational and business use. Feel free to modify and customize according to your needs.

## Changelog

### Version 1.0.0
- Initial release
- Core CRM functionality
- User authentication
- Dashboard analytics
- Contact, Lead, and Deal management
- Activity tracking
- Role-based access control 