@echo off
REM Laravel Application Diagnostic Script for Windows
REM Run this script to diagnose common Laravel issues

echo 🔍 Laravel Application Diagnostics
echo ====================================
echo.

set ISSUES=0
set WARNINGS=0
set SUCCESSES=0

echo 📄 Checking environment configuration...
if exist ".env" (
    echo ✅ .env file exists
    set /a SUCCESSES+=1
    
    findstr /C:"APP_KEY=" .env >nul 2>&1
    if errorlevel 1 (
        echo ❌ APP_KEY is not set in .env
        set /a ISSUES+=1
    ) else (
        echo ✅ APP_KEY is configured
        set /a SUCCESSES+=1
    )
) else (
    echo ❌ .env file is missing
    set /a ISSUES+=1
)

echo.
echo 📁 Checking required directories...
if exist "storage\app" (echo ✅ Storage app directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage app directory is missing & set /a ISSUES+=1)
if exist "storage\framework" (echo ✅ Storage framework directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage framework directory is missing & set /a ISSUES+=1)
if exist "storage\framework\cache" (echo ✅ Storage cache directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage cache directory is missing & set /a ISSUES+=1)
if exist "storage\framework\sessions" (echo ✅ Storage sessions directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage sessions directory is missing & set /a ISSUES+=1)
if exist "storage\framework\views" (echo ✅ Storage views directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage views directory is missing & set /a ISSUES+=1)
if exist "storage\logs" (echo ✅ Storage logs directory exists & set /a SUCCESSES+=1) else (echo ❌ Storage logs directory is missing & set /a ISSUES+=1)
if exist "bootstrap\cache" (echo ✅ Bootstrap cache directory exists & set /a SUCCESSES+=1) else (echo ❌ Bootstrap cache directory is missing & set /a ISSUES+=1)
if exist "resources\views" (echo ✅ Resources views directory exists & set /a SUCCESSES+=1) else (echo ❌ Resources views directory is missing & set /a ISSUES+=1)

echo.
echo 📦 Checking Composer dependencies...
if exist "vendor" (
    echo ✅ vendor directory exists
    set /a SUCCESSES+=1
    
    if exist "vendor\autoload.php" (
        echo ✅ Composer autoload file exists
        set /a SUCCESSES+=1
    ) else (
        echo ❌ Composer autoload file is missing
        set /a ISSUES+=1
    )
) else (
    echo ❌ vendor directory is missing - run: composer install
    set /a ISSUES+=1
)

echo.
echo 🔑 Checking key files...
if exist "composer.json" (echo ✅ Composer configuration exists & set /a SUCCESSES+=1) else (echo ❌ Composer configuration is missing & set /a ISSUES+=1)
if exist "package.json" (echo ✅ NPM configuration exists & set /a SUCCESSES+=1) else (echo ❌ NPM configuration is missing & set /a ISSUES+=1)
if exist "artisan" (echo ✅ Artisan command file exists & set /a SUCCESSES+=1) else (echo ❌ Artisan command file is missing & set /a ISSUES+=1)
if exist "public\index.php" (echo ✅ Public entry point exists & set /a SUCCESSES+=1) else (echo ❌ Public entry point is missing & set /a ISSUES+=1)
if exist "routes\web.php" (echo ✅ Web routes exists & set /a SUCCESSES+=1) else (echo ❌ Web routes is missing & set /a ISSUES+=1)
if exist "bootstrap\app.php" (echo ✅ Bootstrap file exists & set /a SUCCESSES+=1) else (echo ❌ Bootstrap file is missing & set /a ISSUES+=1)

echo.
echo 💨 Checking cache...
php artisan view:clear >nul 2>&1
if errorlevel 1 (
    echo ⚠️  Could not clear view cache
    set /a WARNINGS+=1
) else (
    echo ✅ View cache cleared
    set /a SUCCESSES+=1
)

echo.
echo 📊 DIAGNOSTIC SUMMARY:
echo   Critical Issues: %ISSUES%
echo   Warnings: %WARNINGS%
echo   Passed Checks: %SUCCESSES%
echo.

if %ISSUES% GTR 0 (
    echo ❌ Your application has critical issues that need attention.
    echo 💡 Try running: php artisan optimize:clear
    exit /b 1
) else if %WARNINGS% GTR 0 (
    echo ⚠️  Your application has some warnings but should work.
    exit /b 0
) else (
    echo ✅ All checks passed! Your application looks healthy.
    exit /b 0
)

