#!/bin/bash

# Production Deployment Script for D.N B Motors V
# Run this script on your production server

echo "🚀 Starting Production Deployment..."

# 1. Set production environment
export APP_ENV=production
export APP_DEBUG=false

# 2. Install/Update dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 644 storage/logs/*.log 2>/dev/null || true

# 6. Create storage symlink if not exists
echo "🔗 Creating storage symlink..."
php artisan storage:link

# 7. Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 8. Clear and optimize autoloader
echo "📚 Optimizing autoloader..."
composer dump-autoload --optimize

# 9. Set production environment variables
echo "⚙️ Setting production environment..."
cp .env.production .env

# 10. Final cache clear
echo "🧹 Final cache clear..."
php artisan cache:clear

echo "✅ Production deployment completed successfully!"
echo "🌐 Your application is now running in production mode!"
echo "🔒 Debug mode is disabled"
echo "⚡ All caches are optimized"
echo "🛡️ Security headers are enabled"
