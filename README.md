# Lead Gravity

A PHP/MySQL CRM system for managing PPC leads that integrates with WordPress Lead Gravity plugin via webhooks.

## Features

- **Dashboard**: Real-time lead statistics, charts, and recent leads
- **Lead Management**: Full CRUD operations with filters, status updates, quality scoring
- **Reports**: Date-range analytics, source/campaign performance, geographic distribution
- **Client Management**: Multi-client support with separate webhook tokens (Admin only)
- **User Management**: Role-based access control (Admin, Manager, Agent)
- **Webhook Integration**: Secure endpoint for Lead Gravity plugin

## Requirements

- PHP 8.0+
- MySQL 8.0+
- Apache/Nginx web server
- mod_rewrite enabled (Apache)

## Installation

1. **Upload Files**: Upload the `crm` folder to your web server

2. **Open Installation Page**: Navigate to `https://yourdomain.com/crm/install.php`

3. **Configure Database**: 
   - Enter your MySQL credentials
   - Set your application URL
   - Create admin account

4. **Complete Setup**: The installer will create all tables and configure the system

5. **Delete install.php**: For security, remove or rename `install.php` after installation

## Webhook Integration with Lead Gravity

After installation, you'll receive a webhook URL like:
```
https://yourdomain.com/crm/api/webhook.php?token=YOUR_UNIQUE_TOKEN
```

### Setting up in Lead Gravity:

1. Go to WordPress Admin → Lead Gravity → Settings → Webhooks
2. Add new webhook with your CRM URL
3. Enable the webhook
4. Test by submitting a form

### Webhook Payload

The webhook accepts POST requests with this JSON structure:

```json
{
  "event": "form_submission",
  "submission_id": 123,
  "form_id": 1,
  "form_name": "Contact Form",
  "timestamp": "2024-01-15 10:30:00",
  
  "form_data": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "message": "I need AC repair"
  },
  
  "visitor": {
    "ip_address": "203.0.113.42",
    "city": "Mumbai",
    "device_type": "Mobile",
    "browser": "Chrome",
    "os": "Android"
  },
  
  "attribution": {
    "utm_source": "google",
    "utm_medium": "cpc",
    "utm_campaign": "ac-repair-mumbai",
    "gclid": "Cj0KCQiA..."
  }
}
```

## User Roles

| Role | Permissions |
|------|-------------|
| **Admin** | Full access, client/user management |
| **Manager** | Lead management, reports, team assignment |
| **Agent** | View/update leads, add notes |

## File Structure

```
/crm/
├── index.php           # Login page
├── config.php          # Configuration
├── install.php         # Installation wizard
├── .htaccess           # Apache config
├── api/
│   └── webhook.php     # Webhook endpoint
├── includes/
│   ├── auth.php        # Authentication
│   ├── database.php    # PDO wrapper
│   ├── functions.php   # Helper functions
│   ├── header.php      # Layout header
│   └── footer.php      # Layout footer
├── pages/
│   ├── dashboard.php   # Main dashboard
│   ├── leads.php       # Leads list
│   ├── lead-detail.php # Lead details
│   ├── reports.php     # Analytics
│   ├── clients.php     # Client management
│   └── settings.php    # User settings
└── assets/
    ├── css/
    │   └── style.css   # Styles
    └── js/
        └── app.js      # JavaScript
```

## Security

- All database queries use prepared statements
- Passwords are hashed with bcrypt
- CSRF protection on forms
- Role-based access control
- Webhook token validation
- XSS prevention with output escaping

## Hosting on Hostinger

1. Create a MySQL database in Hostinger's hPanel
2. Upload CRM files via File Manager or FTP
3. Run the installer with your database credentials
4. Configure your domain/subdomain

## License

Private - For internal use only

## Support

For issues or feature requests, contact the development team.
