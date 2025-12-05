# Stratvice Website - Deployment Guide

## Quick Start - Deploy to Hostinger

### Method 1: File Manager Upload (Recommended for First Deploy)

1. **Log into Hostinger**
   - Go to https://hpanel.hostinger.com
   - Navigate to your website

2. **Access File Manager**
   - Click "File Manager" in the control panel
   - Navigate to `public_html` directory

3. **Upload Files**
   - Delete any existing files in `public_html` (backup first!)
   - Upload ALL files from your local project
   - Maintain the folder structure

4. **Set Permissions**
   - Directories: 755
   - Files: 644

5. **Verify Deployment**
   - Visit your domain
   - Test all pages (index.php, careers.php)
   - Check interactive tools
   - Test forms

### Method 2: FTP/SFTP Upload

1. **Get FTP Credentials**
   - In Hostinger panel, go to "FTP Accounts"
   - Note: hostname, username, password, port

2. **Use FTP Client** (FileZilla recommended)
   - Download FileZilla: https://filezilla-project.org
   - Connect using your credentials
   - Navigate to `public_html` on remote
   - Upload all local files

3. **Verify Upload**
   - Check all files transferred successfully
   - Test website functionality

### Method 3: Git Deployment (Future Updates)

1. **Create GitHub Repository**
   ```bash
   # On GitHub, create new repository
   # Then connect your local repo:
   git remote add origin https://github.com/yourusername/stratvice.git
   git branch -M main
   git push -u origin main
   ```

2. **Connect Hostinger to GitHub**
   - In Hostinger panel, go to "Git"
   - Connect your GitHub account
   - Select repository and branch
   - Set deployment path to `public_html`
   - Enable auto-deploy on push

3. **Deploy Updates**
   ```bash
   # Make changes locally
   git add .
   git commit -m "Your update message"
   git push
   # Hostinger auto-deploys!
   ```

---

## Pre-Deployment Checklist

- [ ] Compile Tailwind CSS: `npm run build`
- [ ] Test website on localhost:8080
- [ ] Verify all images load
- [ ] Test all forms
- [ ] Check mobile responsiveness
- [ ] Update contact email if needed
- [ ] Backup existing Hostinger files

---

## Files to Deploy

**Essential Files:**
- `index.php` - Homepage
- `careers.php` - Careers page
- `send.php` - Contact form handler
- `css/output.css` - Compiled styles
- `js/mix.js` - JavaScript utilities
- `js/validate.js` - Form validation
- `img/` - All images
- `business-goal.json` - Lottie animation
- `customer-care.json` - Lottie animation

**Optional (for development):**
- `css/input.css` - Source CSS
- `package.json` - NPM config
- `README.md` - Documentation

**DO NOT Deploy:**
- `node_modules/` - Too large, not needed
- `.git/` - Version control (unless using Git deployment)
- `.env` - Environment variables
- `.DS_Store` - Mac system files

---

## Post-Deployment Verification

1. **Homepage Test**
   - Visit your domain
   - Check hero section loads
   - Verify animations work
   - Test "Get Free Consultation" button

2. **Careers Page Test**
   - Visit yourdomain.com/careers.php
   - Check all 6 internship positions display
   - Test page speed tool
   - Test quotation calculator
   - Submit test application

3. **Forms Test**
   - Fill out contact form
   - Verify email delivery
   - Check validation works

4. **Mobile Test**
   - Open on phone
   - Check responsive design
   - Test mobile menu
   - Verify touch interactions

5. **Performance Test**
   - Check page load speed
   - Verify images optimized
   - Test on slow connection

---

## Troubleshooting

### Issue: Page shows 404 error
- **Solution**: Ensure files are in `public_html` directory
- Check file permissions (644 for files, 755 for directories)

### Issue: CSS not loading
- **Solution**: Verify `css/output.css` exists
- Check file path is correct
- Clear browser cache

### Issue: Images not displaying
- **Solution**: Check `img/` folder uploaded completely
- Verify image paths in HTML
- Check file permissions

### Issue: Forms not working
- **Solution**: Verify `send.php` exists
- Check email configuration in Hostinger
- Test with different email address

### Issue: Lottie animations not showing
- **Solution**: Ensure JSON files uploaded
- Check CDN link for lottie-web
- Verify JavaScript console for errors

---

## Updating Website (After Initial Deploy)

### Using Git (Recommended)

```bash
# Make changes locally
# Test on localhost:8080

# Stage changes
git add .

# Commit with message
git commit -m "feat: add new feature"

# Push to GitHub (if connected)
git push

# If using Hostinger Git integration, it auto-deploys
# Otherwise, upload changed files via FTP
```

### Using FTP

1. Make changes locally
2. Test thoroughly
3. Connect via FTP
4. Upload only changed files
5. Verify on live site

---

## Backup Strategy

**Before Every Major Update:**
1. Download current live files from Hostinger
2. Save to dated folder: `backup-YYYY-MM-DD/`
3. Make changes
4. Deploy
5. If issues, restore from backup

**Automated Backups:**
- Hostinger provides automatic backups
- Access via control panel > Backups
- Can restore entire site if needed

---

## Support

**Hostinger Support:**
- Live Chat: Available 24/7
- Email: support@hostinger.com
- Knowledge Base: https://support.hostinger.com

**Website Issues:**
- Check browser console for errors
- Review server error logs in Hostinger
- Test on different browsers/devices

---

## Quick Commands Reference

```bash
# Git commands
git status              # Check changes
git add .              # Stage all changes
git commit -m "msg"    # Commit changes
git push               # Push to remote
git log                # View history

# Build commands
npm run build          # Compile Tailwind CSS
npm run dev            # Development mode

# Local server
php -S localhost:8080  # Start local server
```

---

## Next Steps

1. ✅ Git repository initialized
2. ✅ Initial commit made
3. ⏳ Deploy to Hostinger
4. ⏳ Connect to GitHub (optional)
5. ⏳ Set up auto-deployment (optional)
6. ⏳ Configure domain SSL
7. ⏳ Set up email forwarding

Good luck with your deployment! 🚀
