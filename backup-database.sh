#!/bin/bash

# Database Backup Script for D.N B Motors V
# Run this script daily via cron

# Configuration
DB_NAME="motors"
DB_USER="root"
DB_PASS=""
BACKUP_DIR="/var/backups/motors"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="motors_backup_$DATE.sql"
RETENTION_DAYS=30

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Create backup
echo "🗄️ Creating database backup..."
if [ -z "$DB_PASS" ]; then
    mysqldump -u $DB_USER $DB_NAME > $BACKUP_DIR/$BACKUP_FILE
else
    mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/$BACKUP_FILE
fi

# Check if backup was successful
if [ $? -eq 0 ]; then
    echo "✅ Backup created successfully: $BACKUP_FILE"
    
    # Compress backup
    gzip $BACKUP_DIR/$BACKUP_FILE
    echo "🗜️ Backup compressed: $BACKUP_FILE.gz"
    
    # Remove old backups (keep only last 30 days)
    find $BACKUP_DIR -name "*.sql.gz" -mtime +$RETENTION_DAYS -delete
    echo "🧹 Old backups cleaned up"
    
    # Log success
    echo "$(date): Database backup completed successfully - $BACKUP_FILE.gz" >> $BACKUP_DIR/backup.log
    
    # Optional: Upload to cloud storage (uncomment if needed)
    # aws s3 cp $BACKUP_DIR/$BACKUP_FILE.gz s3://your-bucket/backups/
    
else
    echo "❌ Backup failed!"
    echo "$(date): Database backup failed" >> $BACKUP_DIR/backup.log
    exit 1
fi

echo "🎯 Backup process completed!"
echo "📁 Backup location: $BACKUP_DIR/$BACKUP_FILE.gz"
echo "📊 Backup size: $(du -h $BACKUP_DIR/$BACKUP_FILE.gz | cut -f1)"
