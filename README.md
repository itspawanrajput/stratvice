# Stratvice - Digital Marketing Agency Website

## Overview
Stratvice is a professional digital marketing agency website built with modern web technologies. The site showcases the agency's services, projects, and provides a contact interface for potential clients.

## Project Structure

```
public_html/
├── index.php                 # Main landing page
├── send.php                  # Form submission handler for contact requests
├── package.json              # NPM dependencies and build scripts
├── business-goal.json        # Lottie animation data for business goal section
├── customer-care.json        # JSON data for customer care content
├── css/
│   ├── input.css            # Tailwind CSS source file
│   ├── output.css           # Compiled Tailwind CSS (production)
│   └── output-v1.1.css      # Alternative CSS version
├── js/
│   ├── mix.js               # Main JavaScript utilities and animations
│   └── validate.js          # Form validation logic
├── img/
│   ├── working-together.avif # Hero/banner image
│   ├── icons/               # SVG icons and favicons
│   │   └── stratvice-logo.svg
│   │   └── fabicon.svg
│   └── clients/             # Client showcase images
│       ├── chat/            # Chat client images
│       ├── choosed/         # Selected/featured clients
│       ├── new/             # New clients
│       └── old/             # Archive clients
├── php/                     # PHP subdirectory with duplicate content
├── upload/                  # File upload handling directory
├── old/                     # Previous versions/backups
└── the/                     # Legacy files directory
```

## Technology Stack

### Frontend
- **HTML5** - Semantic markup structure
- **Tailwind CSS** - Utility-first CSS framework for styling
- **JavaScript (ES6+)** - Interactive features and animations
- **Lottie Web** - Animation library for JSON-based animations
- **Owl Carousel 2** - Image carousel/slider plugin
- **AOS (Animate On Scroll)** - Scroll animation library
- **Font Awesome 6.7** - Icon library

### Backend
- **PHP** - Server-side form processing
- **Mail Functions** - Native PHP mail() for contact form submissions

### Build Tools
- **NPM** - Package manager
- **Tailwind CSS CLI** - CSS preprocessing with watch mode
- **PostCSS** - CSS transformations
- **Autoprefixer** - Browser compatibility prefixes

## Key Features

### 1. **Responsive Navigation**
- Fixed desktop header with logo and menu
- Mobile-friendly navigation
- Smooth scrolling links

### 2. **Hero Section**
- Animated background with Lottie animations
- Business goal visualization
- Call-to-action buttons

### 3. **Services Section**
- Service cards with icons
- Hover animations
- Detailed service descriptions

### 4. **Client Showcase**
- Organized client galleries:
  - Chat clients
  - Selected clients
  - New clients
  - Archive clients

### 5. **Contact Form**
- Name, email, phone, and message fields
- Client-side validation (validate.js)
- Server-side sanitization with htmlspecialchars()
- Email notification to admin

### 6. **Animations & Effects**
- Scroll-triggered animations (AOS)
- GSAP animations (referenced but needs setup)
- Lottie animations for illustrations
- CSS transitions and transforms

## File Descriptions

### Core Pages
- **index.php** - Main landing page with all sections (640 lines)
  - Navigation
  - Hero section with animations
  - About section
  - Services showcase
  - Client section
  - Contact form
  - Footer

- **send.php** - Backend form handler
  - Receives POST requests from contact form
  - Validates and sanitizes input
  - Sends email notifications
  - Returns success/error/invalid responses

### Styling
- **css/input.css** - Tailwind source with custom configurations
- **css/output.css** - Compiled production CSS with all utilities
- **css/output-v1.1.css** - Alternative CSS version (possibly outdated)

### JavaScript
- **js/mix.js** - Main JavaScript module
  - Utility functions
  - Animation controllers
  - Event handlers
  - Mix utilities

- **js/validate.js** - Form validation
  - Email validation
  - Required field checks
  - Error handling
  - User feedback

### Assets
- **img/** - Image directory
  - SVG logos and icons
  - AVIF format images for optimization
  - Client showcase images organized by category
  - Favicon files

### Data Files
- **business-goal.json** - Lottie animation file
  - Contains keyframe animations
  - 1200x1200px canvas
  - 180 frame animation
  - Shows animated business/character illustration

- **customer-care.json** - Structured content data
  - Customer testimonials
  - Service details
  - Company information

### Configuration
- **package.json** - NPM project configuration
  ```json
  {
    "scripts": {
      "build": "tailwindcss -i ./css/input.css -o ./css/output.css --watch"
    },
    "devDependencies": {
      "autoprefixer": "^10.4.21",
      "postcss": "^8.5.6",
      "tailwindcss": "^4.1.10"
    },
    "dependencies": {
      "@tailwindcss/cli": "^4.1.10"
    }
  }
  ```

## Setup & Installation

### Prerequisites
- PHP 7.2+
- Node.js 14+ and npm
- Web server (Apache/Nginx)

### Installation Steps

1. **Clone/Extract Repository**
   ```bash
   cd public_html
   ```

2. **Install Dependencies**
   ```bash
   npm install
   ```

3. **Build CSS**
   ```bash
   npm run build
   ```

4. **Configure Email**
   - Edit `send.php` line 11
   - Update email recipient(s)
   - Configure mail server settings if needed

5. **Start Development Server**
   ```bash
   # CSS build with watch mode
   npm run build
   
   # PHP local server (optional)
   php -S localhost:8000
   ```

## Hostinger Migration Guide

### Pre-Migration Checklist
- [ ] Access Hostinger control panel for current and new account
- [ ] Note current domain and nameservers
- [ ] Create full backup of website files
- [ ] Document current email settings
- [ ] Export email forwarding rules (if any)
- [ ] Note current PHP version and extensions enabled

### Step-by-Step Migration (Hostinger to Hostinger)

#### Phase 1: Prepare New Hosting
1. **Access New Hostinger Account**
   - Log in to new Hostinger control panel
   - Navigate to File Manager or via FTP

2. **Check PHP Version**
   - Go to Settings > PHP Version
   - Ensure PHP 7.2+ is selected (ideally 7.4 or 8.1)
   - Verify extensions: `mail`, `curl`, `json` are enabled

3. **Create Database (if needed in future)**
   - MySQL > Create Database
   - Note database credentials

#### Phase 2: Upload Website Files

**Option A: Using Hostinger File Manager (Easiest)**
1. Log in to new Hostinger control panel
2. Go to File Manager
3. Navigate to `public_html` folder
4. Upload all files and folders:
   - `index.php`, `send.php`
   - `css/` folder
   - `js/` folder
   - `img/` folder
   - `package.json`, `business-goal.json`, `customer-care.json`
5. Set folder permissions to 755 and file permissions to 644

**Option B: Using FTP (Faster for large files)**
1. Get FTP credentials from Hostinger:
   - Settings > FTP/SFTP
   - Create new FTP account or use default
2. Use FTP client (FileZilla, WinSCP, Cyberduck):
   ```
   Host: ftp.yourdomain.com
   Username: [FTP username]
   Password: [FTP password]
   Port: 21
   ```
3. Navigate to `public_html` and upload all files
4. Set permissions:
   - Directories: 755
   - Files: 644
   - `upload/` directory: 755

**Option C: Using SSH (Command line)**
```bash
# Connect via SSH
ssh username@yourdomain.com

# Navigate to public_html
cd public_html

# Upload files (from local machine)
scp -r /path/to/local/files/* username@yourdomain.com:~/public_html/
```

#### Phase 3: Configure Email in send.php
1. In Hostinger, create email account:
   - Email > Create Email Account
   - Example: `contact@yourdomain.com`
2. Update `send.php`:
   ```php
   // Line 11 - Update recipient email
   $to = "contact@yourdomain.com";  // Your new email
   ```
3. Test form submission from website

#### Phase 4: Update Domain & DNS

**If moving domain to new Hostinger account:**
1. Transfer domain:
   - Current account: Generate authorization code
   - New account: Initiate domain transfer
   - Confirm via email

**If keeping domain at current registrar:**
1. Update nameservers to new Hostinger:
   - Go to domain registrar panel
   - Update nameservers:
     ```
     NS1: ns1.hostinger.com
     NS2: ns2.hostinger.com
     NS3: ns3.hostinger.com
     NS4: ns4.hostinger.com
     ```
   - Wait 24-48 hours for DNS propagation

**If domain already on new Hostinger account:**
1. No action needed - DNS already configured

#### Phase 5: Point Domain to New Hosting
1. In new Hostinger account:
   - Domains > Manage Domain
   - Verify domain is pointed to correct hosting account
   - A record should point to new server IP

#### Phase 6: Test Website
- [ ] Visit your domain - loads correctly
- [ ] All images display properly
- [ ] CSS and JavaScript load without errors
- [ ] Test contact form - emails send successfully
- [ ] Check on mobile devices
- [ ] Verify animations work (Lottie, AOS)
- [ ] Check browser console for errors (F12)

#### Phase 7: Setup SSL Certificate
1. In Hostinger panel:
   - Settings > SSL Certificate
   - Install free Hostinger SSL or AutoSSL
   - Enable HTTPS redirect
2. Update `index.php` if any hardcoded URLs:
   - Replace `http://` with `https://`

#### Phase 8: Cleanup & Maintenance
1. Delete old hosting files after 30 days (safety buffer)
2. Setup backups in new Hostinger:
   - Tools > Backups > Enable automatic backups
3. Monitor website for any issues

### Hostinger-Specific Tips

**Email Configuration for New Host**
If using Hostinger's mail server:
```php
// In send.php, you may need to update:
$headers = "From: noreply@yourdomain.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
```

**File Upload Directory Permissions**
```bash
# Via SSH - set permissions for upload directory
chmod 755 upload/
chmod 755 php/
chmod 755 the/
```

**Performance Settings in Hostinger**
1. Enable caching:
   - Settings > Caching > Enable LiteSpeed Cache
2. Optimize images:
   - Already using AVIF (good!)
3. Enable gzip compression:
   - Should be auto-enabled

**Backup Your New Website**
- Create backup immediately after migration:
  - Tools > Backups > Create Backup
  - Enable automatic daily/weekly backups

### Rollback Plan (If Issues Occur)
1. Keep old hosting active for 7+ days
2. If problems on new host:
   - Update domain nameservers back to old host
   - Wait for DNS propagation
   - Investigate issue on new host
   - Update nameservers back once fixed

### DNS Propagation Checker
After updating DNS/domain, verify at:
- https://whatsmydns.net/
- Check A record points to new Hostinger server IP
- Typical propagation time: 24-48 hours

### Contact Hostinger Support
If you encounter issues:
- Hostinger 24/7 Live Chat (login to account)
- Check if PHP extensions needed are enabled
- Verify mail function is not disabled
- Check file permissions are correct

## Running Locally

### Quick Start (Easiest)

**Prerequisites:**
- PHP 7.2+ installed
- Node.js 14+ and npm installed
- Terminal/Command Prompt access

**On macOS:**
```bash
# Navigate to project directory
cd /path/to/public_html

# Install npm dependencies
npm install

# Start building CSS (keep this running)
npm run build

# In a NEW terminal window, start PHP server
php -S localhost:8000

# Open in browser
open http://localhost:8000
```

**On Windows (PowerShell/CMD):**
```bash
# Navigate to project directory
cd path\to\public_html

# Install npm dependencies
npm install

# Start building CSS (keep this running)
npm run build

# In a NEW command window, start PHP server
php -S localhost:8000

# Open in browser
start http://localhost:8000
```

**On Linux:**
```bash
# Navigate to project directory
cd /path/to/public_html

# Install npm dependencies
npm install

# Start building CSS (keep this running)
npm run build &

# In a NEW terminal, start PHP server
php -S localhost:8000

# Open in browser
firefox http://localhost:8000
```

### Method 1: Using PHP Built-in Server (Recommended)

**Pros:** No installation needed, simple setup
**Cons:** Single-threaded, not for production

```bash
# Navigate to project
cd /path/to/public_html

# Start server on port 8000
php -S localhost:8000

# Or use a different port
php -S localhost:3000

# Access at: http://localhost:8000
```

### Method 2: Using XAMPP (Windows/macOS)

1. **Download & Install XAMPP**
   - Windows: https://www.apachefriends.org/download.html
   - macOS: https://www.apachefriends.org/download.html

2. **Copy Project Files**
   ```
   XAMPP folder location:
   - Windows: C:\xampp\htdocs\stratvice
   - macOS: /Applications/XAMPP/htdocs/stratvice
   ```

3. **Start XAMPP**
   - Click Start next to Apache
   - Click Start next to MySQL

4. **Access Website**
   - Open browser to: `http://localhost/stratvice`

5. **Test Email Form**
   - Email will print to console instead of sending
   - Check browser developer tools (F12) > Console

### Method 3: Using Docker (Advanced)

**Create Dockerfile in project root:**
```dockerfile
FROM php:8.1-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html
EXPOSE 80
```

**Build and run:**
```bash
# Build image
docker build -t stratvice-app .

# Run container
docker run -p 8000:80 -v $(pwd):/var/www/html stratvice-app

# Access at: http://localhost:8000
```

### Method 4: Using Docker Compose

**Create docker-compose.yml:**
```yaml
version: '3.8'
services:
  web:
    image: php:8.1-apache
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www/html
    environment:
      - PHP_MAIL_LOG=/tmp/mail.log

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: stratvice
    ports:
      - "3306:3306"
```

**Run:**
```bash
docker-compose up

# Access at: http://localhost:8000
```

### Terminal Setup (Multiple Windows)

**Best Practice - Keep 3 terminals open:**

**Terminal 1 - CSS Build (Watch Mode)**
```bash
cd /path/to/public_html
npm run build
# Output: ✓ Compiled successfully
# Watches for CSS changes automatically
```

**Terminal 2 - PHP Server**
```bash
cd /path/to/public_html
php -S localhost:8000
# Output: Development Server running at http://localhost:8000
```

**Terminal 3 - General Commands**
```bash
# Install packages
npm install

# Check file permissions
ls -la

# View logs
tail -f /tmp/mail.log
```

### Testing Locally

**1. Access Website**
```
http://localhost:8000
```

**2. Check All Sections Load**
- [ ] Navigation loads
- [ ] Hero animations play
- [ ] Images display
- [ ] CSS styling applied
- [ ] Scroll animations work

**3. Test Contact Form**
- [ ] Fill out form
- [ ] Click submit
- [ ] Check browser console (F12 > Console)
- [ ] For email testing, see below

**4. View Console Logs**
```javascript
// Press F12 in browser, go to Console tab
// You should see:
// - Form validation messages
// - Animation console logs
// - Any JavaScript errors
```

### Local Email Testing

Since email won't actually send locally, use these alternatives:

**Option 1: Redirect to Email Log File**
Edit `send.php` line 1:
```php
<?php
ini_set("sendmail_path", "/usr/sbin/sendmail -t -i");
// Mail will be logged to /tmp/mail.log on macOS/Linux
?>
```

**Option 2: Use MailHog (Docker)**
```bash
# Run MailHog - catches all emails
docker run -p 1025:1025 -p 8025:8025 mailhog/mailhog

# MailHog Web UI: http://localhost:8025
```

**Option 3: Echo Form Data**
Temporarily modify `send.php` to debug:
```php
<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";
// This will show form data received
?>
```

**Option 4: Use Mailtrap**
1. Sign up: https://mailtrap.io
2. Get SMTP credentials
3. Update `send.php` with Mailtrap credentials
4. All emails go to Mailtrap inbox

### Troubleshooting Local Setup

**Issue: "PHP command not found"**
```bash
# macOS - Install PHP via Homebrew
brew install php

# Windows - Add PHP to PATH or use XAMPP
```

**Issue: "npm command not found"**
```bash
# Download from: https://nodejs.org
# Includes Node.js and npm
```

**Issue: Port 8000 already in use**
```bash
# Use different port
php -S localhost:3000
php -S localhost:8080
```

**Issue: CSS not updating**
```bash
# Make sure CSS build is running (Terminal 1)
npm run build

# Clear browser cache: Ctrl+Shift+Delete (or Cmd+Shift+Delete on Mac)
# Then reload page
```

**Issue: Images not loading**
```bash
# Check file paths are relative, not absolute
# In index.php - use ./img/... not /img/...
```

**Issue: Form not submitting**
```bash
# Check browser console (F12) for errors
# Check that send.php exists in same directory
# Verify POST method in form: <form method="POST">
```

### Live Reload Setup (Optional)

**Install live-server globally:**
```bash
npm install -g live-server

# Run in project directory
cd /path/to/public_html
live-server

# Browser will auto-refresh on file changes
```

### Database Setup (If Adding Later)

**For MySQL locally via XAMPP:**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create new database: `stratvice_db`
3. Add your connection code to `send.php`

**Connection example:**
```php
$host = "localhost";
$user = "root";
$password = ""; // XAMPP default is empty
$database = "stratvice_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

## Usage

### Building CSS
```bash
npm run build
```
This command compiles `css/input.css` to `css/output.css` with live watch mode enabled.

### Form Submission
The contact form sends POST requests to `send.php` with:
- `name` - Client name
- `email` - Client email
- `phone` - Client phone number
- `message` - Contact message

### Adding New Animations
1. Export Lottie animations as JSON from Adobe After Effects
2. Place in root directory (e.g., `animation.json`)
3. Reference in HTML using Lottie Web library
4. Configure animation parameters in `js/mix.js`

## Browser Support
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Optimization
- AVIF image format for modern browsers
- SVG icons for scalability
- CSS compiled and minified
- Lazy loading for images (via AOS)
- Cached animations with Lottie

## Maintenance

### Updating Content
- Edit sections directly in `index.php`
- Update client images in `img/clients/`
- Modify JSON data in `business-goal.json` and `customer-care.json`

### Updating Styles
- Modify `css/input.css` with Tailwind utilities
- Run `npm run build` to compile changes

### Troubleshooting
- **CSS not updating**: Clear browser cache and rebuild with `npm run build`
- **Animations not playing**: Ensure Lottie Web library is loaded
- **Form not submitting**: Check email configuration in `send.php` and server mail settings
- **Images not loading**: Verify image paths and server permissions

## Directories to Note

### `/php/` - Duplicate PHP Content
Contains backup or alternative PHP files with similar structure to root.

### `/upload/` - File Upload Handler
Directory for handling file uploads (currently with duplicate index.php and send.php).

### `/old/` - Previous Versions
Archive of older website versions including WordPress files.

### `/the/` - Legacy Directory
Contains legacy WordPress files and older versions.

## API Endpoints

### POST /send.php
**Purpose**: Handle contact form submissions

**Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "message": "Your message here"
}
```

**Response**:
- `success` - Form submitted successfully
- `error` - Email sending failed
- `invalid` - Invalid request method

## Future Enhancements

1. **Database Integration**
   - Store submissions in database
   - Create admin panel for lead management

2. **Advanced Email Features**
   - HTML email templates
   - Automated responses
   - Email scheduling

3. **Analytics**
   - Google Analytics integration
   - Form conversion tracking
   - User behavior monitoring

4. **SEO Optimization**
   - Meta tags optimization
   - Schema markup
   - Sitemap generation

5. **CMS Integration**
   - WordPress integration
   - Dynamic content management
   - Content versioning

## Security Considerations

✅ **Implemented**:
- HTML special characters escaping with `htmlspecialchars()`
- Input trimming to remove whitespace
- POST method validation

⚠️ **Recommendations**:
- Implement CSRF token validation
- Add rate limiting for form submissions
- Use environment variables for email configuration
- Implement email verification
- Add reCAPTCHA for spam prevention
- Use prepared statements if database is added
- Implement HTTPS/SSL certificate
- Add security headers (CSP, X-Frame-Options, etc.)

## License
Not specified in project files. Please add appropriate license.

## Support & Contact
For questions or support, contact: v4vikram.dev@gmail.com

---

**Last Updated**: December 5, 2025
**Version**: 1.0
**Status**: Active Development
