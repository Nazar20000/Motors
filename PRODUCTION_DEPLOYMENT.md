# 🚀 PRODUCTION DEPLOYMENT GUIDE

## 📋 **Overview**
This guide will help you deploy D.N B Motors V to production with full security, performance, and monitoring setup.

## 🎯 **Prerequisites**
- Ubuntu 20.04+ server
- Root or sudo access
- Domain name pointing to your server
- Basic Linux knowledge

## 🚀 **Step-by-Step Deployment**

### **1. Server Preparation**

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath unzip git curl -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### **2. MySQL Setup**

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE motors CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'motors_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON motors.* TO 'motors_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### **3. Application Deployment**

```bash
# Clone application
cd /var/www/
sudo git clone [your-repo-url] motors
sudo chown -R www-data:www-data motors
cd motors

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
sudo chmod -R 755 storage/
sudo chmod -R 755 bootstrap/cache/
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/
```

### **4. Environment Configuration**

```bash
# Copy production environment file
cp .env.production .env

# Edit environment file
nano .env
```

**Update these values:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dnbmotorsv.website
DB_DATABASE=motors
DB_USERNAME=motors_user
DB_PASSWORD=your_secure_password
```

### **5. Application Setup**

```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Clear and cache configuration
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **6. Nginx Configuration**

```bash
# Copy nginx configuration
sudo cp nginx-production.conf /etc/nginx/sites-available/motors

# Enable site
sudo ln -s /etc/nginx/sites-available/motors /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Restart nginx
sudo systemctl restart nginx
sudo systemctl enable nginx
```

### **7. PHP-FPM Configuration**

```bash
# Edit PHP-FPM configuration
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
```

**Update these values:**
```ini
user = www-data
group = www-data
listen = /run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
```

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm
sudo systemctl enable php8.2-fpm
```

### **8. SSL Certificate (Let's Encrypt)**

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Get SSL certificate
sudo certbot --nginx -d dnbmotorsv.website

# Test auto-renewal
sudo certbot renew --dry-run
```

### **9. Security Setup**

```bash
# Configure firewall
sudo ufw --force reset
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable

# Install fail2ban
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### **10. Monitoring Setup**

```bash
# Make scripts executable
chmod +x deploy-production.sh
chmod +x backup-database.sh
chmod +x monitor-production.sh

# Setup cron jobs
crontab -e
```

**Add these cron jobs:**
```cron
# Database backup - daily at 2 AM
0 2 * * * /var/www/motors/backup-database.sh

# Production monitoring - every 5 minutes
*/5 * * * * /var/www/motors/monitor-production.sh

# Performance optimization - daily at 6 AM
0 6 * * * cd /var/www/motors && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### **11. Log Rotation**

```bash
# Copy logrotate configuration
sudo cp logrotate-motors.conf /etc/logrotate.d/motors

# Test configuration
sudo logrotate -d /etc/logrotate.d/motors
```

## 🔒 **Security Checklist**

### **Server Security**
- [ ] Firewall (UFW) is configured
- [ ] SSH key authentication only
- [ ] Fail2ban is installed and configured
- [ ] Regular security updates enabled
- [ ] SSL certificate is valid and auto-renewing

### **Application Security**
- [ ] .env file is not accessible via web
- [ ] Debug mode is disabled
- [ ] Admin routes are protected
- [ ] CSRF protection is active
- [ ] Input validation is working

### **Database Security**
- [ ] Database user has minimal privileges
- [ ] Database is not accessible from outside
- [ ] Strong passwords are used
- [ ] Regular backups are configured

## 📊 **Performance Optimization**

### **Caching**
- [ ] Config cache is enabled
- [ ] Route cache is enabled
- [ ] View cache is enabled
- [ ] Browser caching is configured

### **PHP Optimization**
- [ ] OPcache is enabled
- [ ] PHP-FPM is optimized
- [ ] Gzip compression is enabled
- [ ] Static file serving is optimized

## 🧪 **Testing**

### **Functionality Tests**
- [ ] Homepage loads correctly
- [ ] Inventory page works
- [ ] Car details page works
- [ ] Apply online form works
- [ ] Admin panel is accessible
- [ ] Image uploads work

### **Performance Tests**
- [ ] Page load times < 3 seconds
- [ ] Images load properly
- [ ] Mobile responsiveness works
- [ ] Cross-browser compatibility

### **Security Tests**
- [ ] Admin routes are protected
- [ ] CSRF tokens are working
- [ ] SQL injection protection
- [ ] XSS protection

## 📝 **Post-Deployment**

### **Monitoring**
- [ ] Error logs are monitored
- [ ] Performance is tracked
- [ ] Uptime monitoring is active
- [ ] Backup verification

### **Maintenance**
- [ ] Regular security updates
- [ ] Database optimization
- [ ] Log rotation
- [ ] Performance monitoring

## 🆘 **Troubleshooting**

### **Common Issues**

**1. Permission Denied Errors**
```bash
sudo chown -R www-data:www-data /var/www/motors
sudo chmod -R 755 /var/www/motors/storage
sudo chmod -R 755 /var/www/motors/bootstrap/cache
```

**2. 500 Internal Server Error**
```bash
# Check logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/www/motors/storage/logs/laravel.log

# Check permissions
sudo chown -R www-data:www-data /var/www/motors
```

**3. Database Connection Issues**
```bash
# Test database connection
mysql -u motors_user -p motors

# Check .env file
nano .env
```

**4. SSL Certificate Issues**
```bash
# Check certificate status
sudo certbot certificates

# Renew certificate manually
sudo certbot renew
```

## 📞 **Support**

### **Contact Information**
- **Developer**: [Your Contact]
- **Hosting Provider**: [Provider Contact]
- **Domain Provider**: [Domain Contact]

### **Useful Commands**
```bash
# Check service status
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql

# Check logs
sudo tail -f /var/log/nginx/access.log
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/www/motors/storage/logs/laravel.log

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
sudo systemctl restart mysql
```

---

## 🎯 **Final Status**

**Project Status**: ✅ PRODUCTION READY  
**Last Updated**: $(date)  
**Deployed By**: [Your Name]  
**Version**: 1.0.0  

---

**Remember**: Always test in staging environment first and keep regular backups!
