# Lavender Pharmacy - Setup Guide

## Quick Start Installation

### Step 1: Database Setup

1. Open MySQL/phpMyAdmin
2. Create a new database:
   ```sql
   CREATE DATABASE lavender_pharmacy;
   ```

3. Import the database schema:
   ```bash
   mysql -u root -p lavender_pharmacy < database/database.sql
   ```

4. (Optional) Import sample data:
   ```bash
   mysql -u root -p lavender_pharmacy < database/sample_data.sql
   ```

### Step 2: Configuration

1. Edit `config/db_config.php`:
   ```php
   define('DB_HOST', 'localhost');      // Your database host
   define('DB_USER', 'root');           // Your database user
   define('DB_PASS', '');               // Your database password
   define('DB_NAME', 'lavender_pharmacy');  // Database name
   ```

2. Set file permissions:
   ```bash
   chmod 755 uploads/
   chmod 755 logs/
   chmod 644 config/db_config.php
   ```

### Step 3: Test User Accounts

After importing sample data, test with:

**Admin Account:**
- Email: admin@lavenderpharmacy.com
- Password: Admin123456

**Editor Account:**
- Email: editor@lavenderpharmacy.com
- Password: Editor123456

**Customer Account:**
- Email: customer@lavenderpharmacy.com
- Password: Customer123456

### Step 4: Access Application

- **Home**: http://localhost/lavender-pharmacy/
- **Login**: http://localhost/lavender-pharmacy/login.php
- **Register**: http://localhost/lavender-pharmacy/register.php

## Directory Permissions

```bash
# Set permissions for uploads directory
chmod 755 uploads/

# Set permissions for logs directory
chmod 755 logs/

# Set permissions for database backups (if creating)
chmod 755 backups/

# Secure configuration file
chmod 644 config/db_config.php
```

## First-Time Setup Checklist

- [ ] Database created
- [ ] Schema imported
- [ ] Sample data imported
- [ ] db_config.php updated
- [ ] File permissions set
- [ ] Test admin login
- [ ] Test customer registration
- [ ] Test product shopping
- [ ] Test checkout process
- [ ] Test receipt generation

## Troubleshooting

### Can't connect to database
- Verify MySQL is running
- Check credentials in config/db_config.php
- Ensure database exists
- Check user has necessary permissions

### 404 Errors on pages
- Verify web server is running
- Check file paths are correct
- Verify mod_rewrite is enabled (for some servers)
- Check .htaccess files if using Apache

### File upload issues
- Verify uploads/ directory exists
- Check directory permissions (755)
- Verify file size limits in php.ini
- Check max upload size setting

### Session problems
- Check PHP session.save_path setting
- Verify directory permissions for session storage
- Clear browser cookies and cache
- Check PHP session settings

## Performance Optimization

For production, consider:

1. **Enable caching:**
   - Browser caching headers
   - PHP opcode caching (opcache)

2. **Database optimization:**
   - Add indexes
   - Use EXPLAIN for slow queries
   - Regular backups

3. **Code optimization:**
   - Minify CSS/JS
   - Optimize images
   - Lazy load content

## Backup Instructions

### Backup Database
```bash
# Full backup
mysqldump -u root -p lavender_pharmacy > backup.sql

# Scheduled daily backup (add to crontab)
0 2 * * * mysqldump -u root -p password lavender_pharmacy > /backups/lavender_$(date +%Y%m%d).sql
```

### Backup Files
```bash
# Create zip of entire project
zip -r lavender_pharmacy_backup.zip .

# Exclude unnecessary files
zip -r lavender_backup.zip . -x "uploads/*" "logs/*" ".git/*"
```

## Maintenance

### Regular Tasks
- [ ] Check error logs daily
- [ ] Monitor disk space
- [ ] Review user activities
- [ ] Update PHP/MySQL when available
- [ ] Test backups monthly

### Database Maintenance
```sql
-- Optimize tables
OPTIMIZE TABLE users;
OPTIMIZE TABLE products;
OPTIMIZE TABLE orders;

-- Check table integrity
CHECK TABLE users;
CHECK TABLE products;
```

## Security Hardening

1. **Change default database password**
2. **Remove sample data in production**
3. **Update admin email address**
4. **Enable HTTPS**
5. **Set up firewall rules**
6. **Regular security updates**
7. **Monitor error logs**
8. **Restrict directory access**

## Deployment Checklist

- [ ] Update APP_URL constant
- [ ] Change database credentials
- [ ] Remove sample data
- [ ] Update admin email
- [ ] Enable HTTPS
- [ ] Set up daily backups
- [ ] Configure error logging
- [ ] Test all features
- [ ] Set up monitoring
- [ ] Document deployment

## Support

For issues or questions:
- Email: admin@lavenderpharmacy.com
- Phone: 09188887673

---

**Happy deploying!** 🚀
