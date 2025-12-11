# Laravel Application Diagnostic Tool

A comprehensive diagnostic tool to identify and fix common Laravel application issues.

## Features

The diagnostic tool checks for:

- ✅ **Environment Configuration** - .env file, APP_KEY, APP_ENV, database config
- ✅ **Required Directories** - Storage, bootstrap, resources directories
- ✅ **View Files** - All required Blade templates
- ✅ **Composer Dependencies** - Vendor directory, autoload, dev dependencies
- ✅ **Database Connection** - Connection status and required tables
- ✅ **Storage Permissions** - Writable directories
- ✅ **Cache Status** - Cache driver functionality and view cache size
- ✅ **Service Providers** - Loaded providers, dev-only providers in production
- ✅ **Routes** - Route registration and home route
- ✅ **Key Files** - Essential configuration files

## Usage

### Artisan Command (Recommended)

Run the comprehensive diagnostic:

```bash
php artisan diagnose
```

Run with automatic fixes:

```bash
php artisan diagnose --fix
```

### Shell Scripts (Alternative)

**Linux/Mac:**
```bash
chmod +x diagnose.sh
./diagnose.sh
```

**Windows:**
```cmd
diagnose.bat
```

## Output

The diagnostic tool provides three types of results:

### 🚨 Critical Issues
Problems that prevent the application from working correctly. These must be fixed.

Examples:
- Missing .env file
- APP_KEY not set
- Missing view files
- Database connection failures
- Missing required directories

### ⚠️ Warnings
Issues that may cause problems but don't prevent the application from running.

Examples:
- APP_DEBUG enabled in production
- Dev dependencies in production
- Large number of cached views
- Cache table missing for database cache driver

### ✅ Checks Passed
All checks that passed successfully.

## Auto-Fix Features

When using the `--fix` flag, the tool can automatically fix:

1. **Missing .env file** - Creates from .env.example
2. **Missing APP_KEY** - Generates new application key
3. **Cache issues** - Clears all caches (config, route, view, compiled, events)

## Common Issues and Solutions

### Issue: Missing View Files

```
❌ View 'home' is missing
```

**Solution:**
```bash
# Check which views are missing
php artisan views:check

# Clear view cache
php artisan view:clear
```

### Issue: Database Connection Failed

```
❌ Database connection failed
```

**Solution:**
1. Check `.env` file has correct database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. Test connection:
   ```bash
   php artisan db:show
   ```

### Issue: Cache Not Working

```
❌ Cache is not working properly
```

**Solution:**
If using database cache driver:
```bash
php artisan cache:table
php artisan migrate
```

Or switch to file cache in `.env`:
```
CACHE_STORE=file
```

### Issue: Pail in Production

```
❌ Pail service provider is loaded in production
```

**Solution:**
Reinstall dependencies without dev packages:
```bash
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
```

### Issue: Storage Not Writable

```
❌ Storage directory is not writable
```

**Solution:**
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows - Usually not an issue, but check file permissions
```

## Integration with Deployment

Add to your deployment script:

```bash
# After deployment
php artisan diagnose

# If issues found, try auto-fix
php artisan diagnose --fix

# Verify again
php artisan diagnose
```

## Exit Codes

- `0` - All checks passed or only warnings
- `1` - Critical issues found

This allows use in CI/CD pipelines:

```yaml
- name: Check application health
  run: php artisan diagnose || exit 1
```

## Tips

1. **Run regularly** - Check application health before deployments
2. **Use --fix** - Let the tool fix common issues automatically
3. **Check logs** - After running diagnostics, check `storage/logs/laravel.log` for details
4. **Production checks** - Always run diagnostics after deploying to production

## Related Commands

- `php artisan views:check` - Check view files specifically
- `php artisan optimize:clear` - Clear all caches
- `php artisan config:clear` - Clear configuration cache
- `php artisan route:clear` - Clear route cache
- `php artisan view:clear` - Clear view cache

