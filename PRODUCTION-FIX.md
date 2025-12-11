# Production Server Fix Guide

## Quick Fix Commands

Run these commands on your production server in order:

### 1. Clear All Caches (MOST IMPORTANT)
```bash
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### 2. Generate APP_KEY
```bash
php artisan key:generate --force
```

### 3. Clear Compiled Views Manually
```bash
# Remove all compiled view files
find storage/framework/views -name "*.php" -type f -delete
# Or if find doesn't work:
rm -f storage/framework/views/*.php
```

### 4. Set DB_CONNECTION in .env
Edit your `.env` file and add/update:
```env
DB_CONNECTION=mysql
DB_HOST=s21.hosterpk.com
DB_PORT=3306
DB_DATABASE=nazaarac_nc
DB_USERNAME=nazaarac_nc
DB_PASSWORD=asdfqwer1234asdfqwer1234@@@@
```

### 5. Verify View Files Exist
```bash
# Check if views exist
ls -la resources/views/home.blade.php
ls -la resources/views/layouts/app.blade.php
```

### 6. Run Diagnostic Again
```bash
php artisan diagnose --fix
```

## Automated Fix Script

You can also use the automated fix script:

```bash
# Make it executable
chmod +x fix-production.sh

# Run it
./fix-production.sh
```

## Why This Happens

The "View not found" error when files exist is usually caused by:

1. **Cached view paths** - Laravel caches the view finder paths
2. **Compiled view cache** - Old compiled views pointing to wrong locations
3. **Config cache** - Cached configuration with wrong view paths
4. **Bootstrap cache** - Cached bootstrap files

## After Fixing

Once fixed, you can optimize for production:

```bash
# Cache config and routes for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Note:** Only cache after everything is working! Don't cache if you're still debugging.

## Verification

After running the fixes, verify:

```bash
# Check if views are now found
php artisan views:check

# Run full diagnostic
php artisan diagnose
```

## If Still Not Working

If views are still not found after clearing caches:

1. **Check file permissions:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod -R 755 resources/views
   ```

2. **Check file ownership:**
   ```bash
   # Adjust user:group as needed
   chown -R nazaarac:nazaarac storage bootstrap/cache resources/views
   ```

3. **Verify view paths in config:**
   ```bash
   php artisan tinker
   # Then run:
   view()->getFinder()->getPaths()
   ```

4. **Check for symlink issues:**
   ```bash
   ls -la resources/views
   # Make sure it's not a broken symlink
   ```

## Common Production Issues

### Issue: Views exist but Laravel can't find them
**Solution:** Clear all caches (Step 1 above)

### Issue: APP_KEY not set
**Solution:** Run `php artisan key:generate --force`

### Issue: DB_CONNECTION not set
**Solution:** Add to `.env` file (Step 4 above)

### Issue: Too many cached views (300+)
**Solution:** Clear view cache and let Laravel rebuild them

