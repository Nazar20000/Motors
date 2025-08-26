#!/bin/bash

# Production Monitoring Script for D.N B Motors V
# Run this script every 5 minutes via cron

# Configuration
LOG_FILE="/var/log/motors/monitoring.log"
ALERT_EMAIL="admin@dnbmotorsv.website"
WEBSITE_URL="https://dnbmotorsv.website"
APP_DIR="/var/www/motors"

# Create log directory
mkdir -p /var/log/motors

# Function to log messages
log_message() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" >> $LOG_FILE
}

# Function to send alert
send_alert() {
    echo "$1" | mail -s "MOTORS ALERT: $2" $ALERT_EMAIL
}

# Start monitoring
log_message "Starting production monitoring..."

# 1. Check if website is accessible
log_message "Checking website accessibility..."
if curl -f -s $WEBSITE_URL > /dev/null; then
    log_message "✅ Website is accessible"
else
    log_message "❌ Website is not accessible!"
    send_alert "Website is down!" "Website accessibility check failed"
fi

# 2. Check disk space
log_message "Checking disk space..."
DISK_USAGE=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    log_message "⚠️ Disk usage is high: ${DISK_USAGE}%"
    send_alert "High disk usage: ${DISK_USAGE}%" "Disk space warning"
else
    log_message "✅ Disk usage is normal: ${DISK_USAGE}%"
fi

# 3. Check memory usage
log_message "Checking memory usage..."
MEMORY_USAGE=$(free | grep Mem | awk '{printf "%.0f", $3/$2 * 100.0}')
if [ $MEMORY_USAGE -gt 80 ]; then
    log_message "⚠️ Memory usage is high: ${MEMORY_USAGE}%"
    send_alert "High memory usage: ${MEMORY_USAGE}%" "Memory warning"
else
    log_message "✅ Memory usage is normal: ${MEMORY_USAGE}%"
fi

# 4. Check PHP-FPM status
log_message "Checking PHP-FPM status..."
if systemctl is-active --quiet php8.2-fpm; then
    log_message "✅ PHP-FPM is running"
else
    log_message "❌ PHP-FPM is not running!"
    send_alert "PHP-FPM is down!" "PHP-FPM service check failed"
fi

# 5. Check Nginx status
log_message "Checking Nginx status..."
if systemctl is-active --quiet nginx; then
    log_message "✅ Nginx is running"
else
    log_message "❌ Nginx is not running!"
    send_alert "Nginx is down!" "Nginx service check failed"
fi

# 6. Check MySQL status
log_message "Checking MySQL status..."
if systemctl is-active --quiet mysql; then
    log_message "✅ MySQL is running"
else
    log_message "❌ MySQL is not running!"
    send_alert "MySQL is down!" "MySQL service check failed"
fi

# 7. Check application logs for errors
log_message "Checking application logs for errors..."
ERROR_COUNT=$(tail -100 $APP_DIR/storage/logs/laravel.log 2>/dev/null | grep -c "ERROR\|CRITICAL\|FATAL" || echo "0")
if [ $ERROR_COUNT -gt 10 ]; then
    log_message "⚠️ High error count in logs: $ERROR_COUNT"
    send_alert "High error count: $ERROR_COUNT" "Application error warning"
else
    log_message "✅ Error count is normal: $ERROR_COUNT"
fi

# 8. Check storage permissions
log_message "Checking storage permissions..."
if [ -w "$APP_DIR/storage" ] && [ -w "$APP_DIR/bootstrap/cache" ]; then
    log_message "✅ Storage permissions are correct"
else
    log_message "❌ Storage permissions are incorrect!"
    send_alert "Storage permissions issue!" "Permission check failed"
fi

# 9. Check SSL certificate expiry
log_message "Checking SSL certificate..."
SSL_EXPIRY=$(echo | openssl s_client -servername $WEBSITE_URL -connect $WEBSITE_URL:443 2>/dev/null | openssl x509 -noout -dates | grep notAfter | cut -d= -f2)
if [ ! -z "$SSL_EXPIRY" ]; then
    EXPIRY_DATE=$(date -d "$SSL_EXPIRY" +%s)
    CURRENT_DATE=$(date +%s)
    DAYS_LEFT=$(( ($EXPIRY_DATE - $CURRENT_DATE) / 86400 ))
    
    if [ $DAYS_LEFT -lt 30 ]; then
        log_message "⚠️ SSL certificate expires in $DAYS_LEFT days"
        send_alert "SSL expires in $DAYS_LEFT days" "SSL certificate warning"
    else
        log_message "✅ SSL certificate is valid for $DAYS_LEFT days"
    fi
else
    log_message "❌ Could not check SSL certificate"
fi

# 10. Check cron jobs
log_message "Checking cron jobs..."
if crontab -l | grep -q "monitor-production.sh"; then
    log_message "✅ Monitoring cron job is active"
else
    log_message "⚠️ Monitoring cron job is not found"
fi

# 11. Check backup status
log_message "Checking backup status..."
BACKUP_DIR="/var/backups/motors"
if [ -d "$BACKUP_DIR" ]; then
    LATEST_BACKUP=$(find $BACKUP_DIR -name "*.sql.gz" -type f -printf '%T@ %p\n' | sort -n | tail -1 | cut -d' ' -f2-)
    if [ ! -z "$LATEST_BACKUP" ]; then
        BACKUP_AGE=$(( ($(date +%s) - $(stat -c %Y "$LATEST_BACKUP")) / 86400 ))
        if [ $BACKUP_AGE -gt 2 ]; then
            log_message "⚠️ Latest backup is $BACKUP_AGE days old"
            send_alert "Backup is $BACKUP_AGE days old" "Backup age warning"
        else
            log_message "✅ Latest backup is recent: $BACKUP_AGE days old"
        fi
    else
        log_message "❌ No backups found"
        send_alert "No backups found!" "Backup check failed"
    fi
else
    log_message "❌ Backup directory not found"
fi

# Summary
log_message "Production monitoring completed"
log_message "----------------------------------------"

# Send daily summary (only once per day at 9 AM)
if [ $(date +%H) -eq 9 ] && [ $(date +%M) -lt 10 ]; then
    SUMMARY=$(tail -50 $LOG_FILE | grep -E "(✅|❌|⚠️)" | tail -20)
    echo "$SUMMARY" | mail -s "Daily Production Summary - $(date +%Y-%m-%d)" $ALERT_EMAIL
fi
