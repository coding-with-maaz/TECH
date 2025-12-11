@echo off
REM Production Fix Script for Windows
REM Run this script to fix common production issues

echo 🔧 Laravel Production Fix Script
echo =================================
echo.

echo Step 1: Clearing all caches...
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear
echo ✅ All caches cleared
echo.

echo Step 2: Checking APP_KEY...
findstr /C:"APP_KEY=base64:" .env >nul 2>&1
if errorlevel 1 (
    echo Generating APP_KEY...
    php artisan key:generate --force
    echo ✅ APP_KEY generated
) else (
    echo ✅ APP_KEY already exists
)
echo.

echo Step 3: Clearing compiled views...
if exist "storage\framework\views" (
    del /Q storage\framework\views\*.php 2>nul
    echo ✅ Compiled views cleared
) else (
    echo ⚠️  View cache directory not found
)
echo.

echo Step 4: Verifying view files...
dir /B /S resources\views\*.blade.php 2>nul | find /C /V "" > temp_count.txt
set /p VIEW_COUNT=<temp_count.txt
del temp_count.txt
if %VIEW_COUNT% GTR 0 (
    echo ✅ Found %VIEW_COUNT% view files
) else (
    echo ❌ No view files found!
)
echo.

echo Step 5: Running final diagnostics...
php artisan diagnose
echo.

echo ✅ Production fix complete!
echo.
echo If issues persist:
echo   1. Verify .env file has correct settings
echo   2. Run: php artisan config:cache
echo   3. Run: php artisan route:cache
echo   4. Run: php artisan view:cache

