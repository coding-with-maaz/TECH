#!/bin/bash

# Laravel Application Diagnostic Script
# Run this script to diagnose common Laravel issues

echo "🔍 Laravel Application Diagnostics"
echo "===================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

ISSUES=0
WARNINGS=0
SUCCESSES=0

# Function to check file/directory
check_item() {
    if [ -e "$1" ]; then
        echo -e "${GREEN}✅ $2 exists${NC}"
        ((SUCCESSES++))
        return 0
    else
        echo -e "${RED}❌ $2 is missing: $1${NC}"
        ((ISSUES++))
        return 1
    fi
}

# Function to check writable
check_writable() {
    if [ -w "$1" ]; then
        echo -e "${GREEN}✅ $2 is writable${NC}"
        ((SUCCESSES++))
        return 0
    else
        echo -e "${RED}❌ $2 is not writable: $1${NC}"
        ((ISSUES++))
        return 1
    fi
}

echo "📄 Checking environment configuration..."
if [ -f ".env" ]; then
    echo -e "${GREEN}✅ .env file exists${NC}"
    ((SUCCESSES++))
    
    # Check APP_KEY
    if grep -q "APP_KEY=" .env && ! grep -q "APP_KEY=$" .env && ! grep -q "^APP_KEY=\s*$" .env; then
        echo -e "${GREEN}✅ APP_KEY is configured${NC}"
        ((SUCCESSES++))
    else
        echo -e "${RED}❌ APP_KEY is not set in .env${NC}"
        ((ISSUES++))
    fi
else
    echo -e "${RED}❌ .env file is missing${NC}"
    ((ISSUES++))
fi

echo ""
echo "📁 Checking required directories..."
check_item "storage/app" "Storage app directory"
check_item "storage/framework" "Storage framework directory"
check_item "storage/framework/cache" "Storage cache directory"
check_item "storage/framework/sessions" "Storage sessions directory"
check_item "storage/framework/views" "Storage views directory"
check_item "storage/logs" "Storage logs directory"
check_item "bootstrap/cache" "Bootstrap cache directory"
check_item "resources/views" "Resources views directory"

echo ""
echo "🔐 Checking storage permissions..."
check_writable "storage" "Storage directory"
check_writable "storage/app" "Storage app directory"
check_writable "storage/framework" "Storage framework directory"
check_writable "storage/logs" "Storage logs directory"
check_writable "bootstrap/cache" "Bootstrap cache directory"

echo ""
echo "📦 Checking Composer dependencies..."
if [ -d "vendor" ]; then
    echo -e "${GREEN}✅ vendor directory exists${NC}"
    ((SUCCESSES++))
    
    if [ -f "vendor/autoload.php" ]; then
        echo -e "${GREEN}✅ Composer autoload file exists${NC}"
        ((SUCCESSES++))
    else
        echo -e "${RED}❌ Composer autoload file is missing${NC}"
        ((ISSUES++))
    fi
    
    # Check for dev dependencies in production
    if [ -d "vendor/laravel/pail" ] && [ "$APP_ENV" = "production" ]; then
        echo -e "${YELLOW}⚠️  Pail is installed in production (should use --no-dev)${NC}"
        ((WARNINGS++))
    fi
else
    echo -e "${RED}❌ vendor directory is missing - run: composer install${NC}"
    ((ISSUES++))
fi

echo ""
echo "🔑 Checking key files..."
check_item "composer.json" "Composer configuration"
check_item "package.json" "NPM configuration"
check_item "artisan" "Artisan command file"
check_item "public/index.php" "Public entry point"
check_item "routes/web.php" "Web routes"
check_item "bootstrap/app.php" "Bootstrap file"

echo ""
echo "💾 Checking database..."
if php artisan db:show &>/dev/null 2>&1; then
    echo -e "${GREEN}✅ Database connection successful${NC}"
    ((SUCCESSES++))
else
    echo -e "${RED}❌ Database connection failed${NC}"
    echo -e "${YELLOW}⚠️  Check DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env${NC}"
    ((ISSUES++))
    ((WARNINGS++))
fi

echo ""
echo "💨 Checking cache..."
CACHED_VIEWS=$(find storage/framework/views -name "*.php" 2>/dev/null | wc -l)
if [ "$CACHED_VIEWS" -gt 100 ]; then
    echo -e "${YELLOW}⚠️  Large number of cached views ($CACHED_VIEWS) - consider clearing${NC}"
    ((WARNINGS++))
else
    echo -e "${GREEN}✅ View cache size is normal ($CACHED_VIEWS files)${NC}"
    ((SUCCESSES++))
fi

echo ""
echo "📊 DIAGNOSTIC SUMMARY:"
echo "  Critical Issues: $ISSUES"
echo "  Warnings: $WARNINGS"
echo "  Passed Checks: $SUCCESSES"
echo ""

if [ $ISSUES -gt 0 ]; then
    echo -e "${RED}❌ Your application has critical issues that need attention.${NC}"
    echo "💡 Try running: php artisan optimize:clear"
    exit 1
elif [ $WARNINGS -gt 0 ]; then
    echo -e "${YELLOW}⚠️  Your application has some warnings but should work.${NC}"
    exit 0
else
    echo -e "${GREEN}✅ All checks passed! Your application looks healthy.${NC}"
    exit 0
fi

