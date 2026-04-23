#!/bin/bash

# Validation script for Filament 403 Fix
# This script validates all changes made to fix the intermittent 403 errors

set -e

echo "=========================================="
echo "  Filament 403 Fix - Validation Script"
echo "=========================================="
echo ""

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counter
CHECKS_PASSED=0
CHECKS_FAILED=0

# Function to check condition
check_condition() {
    local description=$1
    local command=$2
    
    if eval "$command" > /dev/null 2>&1; then
        echo -e "${GREEN}✓${NC} $description"
        ((CHECKS_PASSED++))
    else
        echo -e "${RED}✗${NC} $description"
        ((CHECKS_FAILED++))
    fi
}

# Function to verify file exists
check_file_exists() {
    local file=$1
    local description=$2
    
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} $description"
        ((CHECKS_PASSED++))
    else
        echo -e "${RED}✗${NC} $description"
        ((CHECKS_FAILED++))
    fi
}

# Function to check content in file
check_content() {
    local file=$1
    local pattern=$2
    local description=$3
    
    if grep -q "$pattern" "$file"; then
        echo -e "${GREEN}✓${NC} $description"
        ((CHECKS_PASSED++))
    else
        echo -e "${RED}✗${NC} $description"
        ((CHECKS_FAILED++))
    fi
}

echo -e "${YELLOW}1. Middleware Validation${NC}"
echo "---"

check_file_exists "app/Http/Middleware/EnsureUserIsAdmin.php" "Middleware file exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "class EnsureUserIsAdmin" "Middleware class defined"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "public function handle" "Handle method exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "isLivewireRequest" "Livewire detection method exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "logAuthorizationFailure" "Logging method exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "handleUnauthorized" "Unauthorized handler exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "handleForbidden" "Forbidden handler exists"
check_content "app/Http/Middleware/EnsureUserIsAdmin.php" "Log::warning" "Logging implemented"

echo ""
echo -e "${YELLOW}2. Configuration Validation${NC}"
echo "---"

check_file_exists ".env.production" "Production env file exists"
check_content ".env.production" "SESSION_LIFETIME=240" "Session lifetime set to 240 minutes"
check_content ".env.production" "SESSION_DOMAIN=.chelistico.ar" "Session domain configured for subdomains"
check_content ".env.production" "SESSION_SECURE_COOKIE=true" "Secure cookie enabled"
check_content ".env.production" "SESSION_HTTP_ONLY=true" "HTTP only cookie enabled"
check_content ".env.production" "SESSION_SAME_SITE=lax" "SameSite policy set to lax"
check_content ".env.production" "SESSION_DRIVER=database" "Session driver is database"

echo ""
echo -e "${YELLOW}3. Routes Validation${NC}"
echo "---"

check_file_exists "routes/api.php" "API routes file exists"
check_content "routes/api.php" "middleware.*auth:sanctum.*admin" "Admin middleware applied to API routes"
check_content "routes/api.php" "Route::prefix('admin')" "Admin route prefix present"

echo ""
echo -e "${YELLOW}4. Service Provider Validation${NC}"
echo "---"

check_file_exists "app/Providers/AppServiceProvider.php" "AppServiceProvider exists"
check_content "app/Providers/AppServiceProvider.php" "configureRequestLogging" "Logging configuration method exists"
check_content "app/Providers/AppServiceProvider.php" "DEBUG_ADMIN_REQUESTS" "Debug logging support added"

echo ""
echo -e "${YELLOW}5. Bootstrap Configuration Validation${NC}"
echo "---"

check_file_exists "bootstrap/app.php" "Bootstrap app file exists"
check_content "bootstrap/app.php" "EnsureUserIsAdmin" "Middleware imported"
check_content "bootstrap/app.php" "'admin' => EnsureUserIsAdmin::class" "Middleware alias registered"

echo ""
echo -e "${YELLOW}6. Documentation Validation${NC}"
echo "---"

check_file_exists "FILAMENT_403_FIX.md" "Fix documentation exists"

echo ""
echo "=========================================="
echo -e "${YELLOW}Validation Summary${NC}"
echo "=========================================="
echo -e "${GREEN}Passed: $CHECKS_PASSED${NC}"
echo -e "${RED}Failed: $CHECKS_FAILED${NC}"

if [ $CHECKS_FAILED -eq 0 ]; then
    echo ""
    echo -e "${GREEN}✓ All checks passed!${NC}"
    echo ""
    echo "Next steps:"
    echo "1. Review the changes: git diff"
    echo "2. Deploy to production"
    echo "3. Run post-deploy validation:"
    echo "   - Test Filament login at https://api.chelistico.ar/admin/login"
    echo "   - Test article creation with slow interactions"
    echo "   - Monitor logs: tail -f storage/logs/laravel.log"
    exit 0
else
    echo ""
    echo -e "${RED}✗ Some checks failed. Please review the issues above.${NC}"
    exit 1
fi
