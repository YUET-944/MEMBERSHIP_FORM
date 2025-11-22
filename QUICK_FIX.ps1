# Quick PostgreSQL Database Setup Script
# Run: .\QUICK_FIX.ps1

Write-Host "=== PostgreSQL Database Setup ===" -ForegroundColor Cyan
Write-Host ""

# Check if PostgreSQL service is running
$service = Get-Service -Name "postgresql-x64-18" -ErrorAction SilentlyContinue
if ($service -and $service.Status -eq 'Running') {
    Write-Host "✅ PostgreSQL service is running" -ForegroundColor Green
} else {
    Write-Host "❌ PostgreSQL service is not running!" -ForegroundColor Red
    Write-Host "Start it with: Start-Service postgresql-x64-18" -ForegroundColor Yellow
    exit
}

Write-Host ""
Write-Host "Current .env configuration:" -ForegroundColor Cyan
$envContent = Get-Content .env | Select-String "DB_"
$envContent

Write-Host ""
Write-Host "Options:" -ForegroundColor Cyan
Write-Host "1. I know the correct password"
Write-Host "2. I need to reset the password"
Write-Host "3. I want to use pgAdmin (GUI)"
Write-Host ""

$choice = Read-Host "Enter choice (1-3)"

if ($choice -eq "1") {
    $password = Read-Host "Enter PostgreSQL password for user 'postgres'" -AsSecureString
    $BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($password)
    $plainPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)
    
    # Update .env
    (Get-Content .env) -replace 'DB_PASSWORD=.*', "DB_PASSWORD=$plainPassword" | Set-Content .env
    Write-Host "✅ .env updated" -ForegroundColor Green
    
    # Try to create database
    Write-Host ""
    Write-Host "Creating database..." -ForegroundColor Cyan
    php setup_database.php
    
} elseif ($choice -eq "2") {
    Write-Host ""
    Write-Host "To reset password:" -ForegroundColor Yellow
    Write-Host "1. Edit: C:\Program Files\PostgreSQL\18\data\pg_hba.conf"
    Write-Host "2. Change 'md5' to 'trust' for local connections"
    Write-Host "3. Restart PostgreSQL: Restart-Service postgresql-x64-18"
    Write-Host "4. Connect: cd 'C:\Program Files\PostgreSQL\18\bin'; .\psql.exe -U postgres"
    Write-Host "5. Run: ALTER USER postgres WITH PASSWORD 'NewPassword123!';"
    Write-Host "6. Revert pg_hba.conf and restart service"
    
} elseif ($choice -eq "3") {
    Write-Host ""
    Write-Host "Using pgAdmin:" -ForegroundColor Yellow
    Write-Host "1. Open pgAdmin"
    Write-Host "2. Connect to PostgreSQL (try common passwords: postgres, admin, password)"
    Write-Host "3. Right-click Databases → Create → Database"
    Write-Host "4. Name: membership_db"
    Write-Host "5. Update DB_PASSWORD in .env with your password"
    Write-Host "6. Run: php artisan migrate"
}

Write-Host ""
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

