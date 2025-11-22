# 🗄️ PostgreSQL Database Setup Guide

## ❌ Current Error
```
FATAL: password authentication failed for user "postgres"
```

## ✅ Solution Steps

### Option 1: Use Default PostgreSQL User (Recommended)

1. **Find your PostgreSQL password:**
   - If you installed PostgreSQL, you set a password during installation
   - Check if you saved it somewhere
   - Or reset it (see below)

2. **Update .env file:**
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=membership_db
   DB_USERNAME=postgres
   DB_PASSWORD=your_postgres_password_here
   ```

3. **Create the database:**
   ```bash
   # Using psql command line
   psql -U postgres
   # Enter your password when prompted
   ```

   Then in psql:
   ```sql
   CREATE DATABASE membership_db;
   \q
   ```

### Option 2: Create New PostgreSQL User

1. **Connect to PostgreSQL:**
   ```bash
   psql -U postgres
   ```

2. **Create database and user:**
   ```sql
   CREATE DATABASE membership_db;
   CREATE USER membership_user WITH PASSWORD 'SecurePassword123!';
   GRANT ALL PRIVILEGES ON DATABASE membership_db TO membership_user;
   \q
   ```

3. **Update .env:**
   ```env
   DB_USERNAME=membership_user
   DB_PASSWORD=SecurePassword123!
   ```

### Option 3: Reset PostgreSQL Password

1. **Edit pg_hba.conf:**
   - Location: `C:\Program Files\PostgreSQL\[version]\data\pg_hba.conf`
   - Change `md5` to `trust` for local connections
   - Restart PostgreSQL service

2. **Connect without password:**
   ```bash
   psql -U postgres
   ```

3. **Set new password:**
   ```sql
   ALTER USER postgres WITH PASSWORD 'NewPassword123!';
   ```

4. **Revert pg_hba.conf** (change back to `md5`)
   - Restart PostgreSQL service

5. **Update .env with new password**

## 🚀 Quick Setup Commands

### Windows (PowerShell)

```powershell
# Option A: Using psql
$env:PGPASSWORD='your_password'
psql -U postgres -c "CREATE DATABASE membership_db;"

# Option B: Using pgAdmin (GUI)
# Open pgAdmin → Right-click Databases → Create → Database
# Name: membership_db
```

### Create Database Script

Save this as `create_db.bat`:
```batch
@echo off
echo Creating membership_db database...
psql -U postgres -c "CREATE DATABASE membership_db;"
if %errorlevel% equ 0 (
    echo Database created successfully!
) else (
    echo Failed to create database. Check your PostgreSQL password.
)
pause
```

## ✅ After Database Creation

1. **Update .env with correct credentials**

2. **Test connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## 🔍 Troubleshooting

### Check PostgreSQL is Running
```bash
# Windows
Get-Service -Name postgresql*

# Or check in Services app
# Look for "postgresql-x64-[version]"
```

### Check Connection
```bash
# Test connection
psql -U postgres -h 127.0.0.1 -p 5432 -d postgres
```

### Common Issues

1. **"password authentication failed"**
   - Wrong password in .env
   - User doesn't exist
   - Solution: Check/update .env password

2. **"database does not exist"**
   - Database not created
   - Solution: Create database first

3. **"connection refused"**
   - PostgreSQL not running
   - Solution: Start PostgreSQL service

## 📝 Quick Fix Command

If you know your PostgreSQL password:

```bash
# Update .env file
# Set DB_PASSWORD=your_actual_password

# Then create database
psql -U postgres -c "CREATE DATABASE membership_db;"

# Test connection
php artisan migrate:status
```

---

**Need Help?** Share your PostgreSQL installation details and I'll provide specific steps!

