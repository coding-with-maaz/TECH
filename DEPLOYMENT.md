# Deployment Guide

## Production Deployment Checklist

### 1. Install Dependencies
**Important**: Always use `--no-dev` flag in production to exclude development dependencies:

```bash
composer install --no-dev --optimize-autoloader
```

This prevents development-only packages (like Laravel Pail, Pest, etc.) from being installed on production servers.

### 2. Clear All Caches
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 3. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 4. Verify Views
Run the diagnostic command to ensure all views are present:
```bash
php artisan views:check
```

### 5. Set Proper Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Environment Configuration
- Ensure `.env` file is properly configured
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Verify database connection settings

## Common Issues

### Missing View Files
If you see "View not found" errors:
1. Verify all files in `resources/views/` are deployed
2. Run `php artisan views:check` to diagnose
3. Clear view cache: `php artisan view:clear`

### Development Dependencies in Production
If you see errors about missing packages (like Pail, Pest, etc.):
1. Ensure you ran `composer install --no-dev`
2. Clear package discovery cache: `php artisan package:discover --ansi`
3. Re-run with `--no-dev` flag

### Cache Issues
If changes aren't reflecting:
1. Run `php artisan optimize:clear`
2. Then run the optimize commands again

