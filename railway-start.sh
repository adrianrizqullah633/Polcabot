#!/bin/bash
set -e

echo "=========================================="
echo "🚀 Starting Railway Application"
echo "=========================================="

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear

# Run migrations (hanya yang baru, tidak drop table)
echo "📦 Running migrations..."
php artisan migrate --force || echo "⚠️  Migration failed or already up to date"

# Optimize
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link (if not exists)
echo "🔗 Creating storage link..."
php artisan storage:link || echo "Storage link already exists"

echo "=========================================="
echo "✅ Application Ready"
echo "=========================================="

# Start server
echo "🌐 Starting web server on 0.0.0.0:${PORT}..."
php artisan serve --host=0.0.0.0 --port=$PORT