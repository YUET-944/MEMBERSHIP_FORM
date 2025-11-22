# ⚡ Quick Commands Reference

## 🚀 Development Servers

```bash
# Start Laravel server
php artisan serve

# Start Vite dev server (in separate terminal)
npm run dev

# Build for production
npm run build
```

## 👤 Admin Management

```bash
# Create admin user
php artisan admin:create --email=admin@example.com --password=SecurePass123!

# Create with custom name and role
php artisan admin:create --name="System Admin" --email=admin@example.com --role=super_admin

# Interactive creation (will prompt for details)
php artisan admin:create
```

## 🔐 Security

```bash
# Generate encryption key
php artisan encryption:generate-key

# Generate application key
php artisan key:generate

# Clear all caches
php artisan optimize:clear
```

## 🗄️ Database

```bash
# Run migrations
php artisan migrate

# Fresh migration (drops all tables)
php artisan migrate:fresh

# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback
```

## 🧪 Testing

```bash
# Test route (browser)
http://127.0.0.1:8000/test-member

# Interactive testing
php artisan tinker

# List all routes
php artisan route:list

# Clear route cache
php artisan route:clear
```

## 📦 Package Management

```bash
# Install Composer packages
composer install

# Update packages
composer update

# Install NPM packages
npm install

# Update NPM packages
npm update
```

## 🔍 Debugging

```bash
# Clear config cache
php artisan config:clear

# Clear application cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Clear all caches
php artisan optimize:clear

# Show environment
php artisan env
```

## 📝 Code Quality

```bash
# Format code (if Laravel Pint installed)
php artisan pint

# Run tests (if PHPUnit configured)
php artisan test
```

## 🌐 Application URLs

- **Homepage:** http://127.0.0.1:8000
- **Registration:** http://127.0.0.1:8000/membership/register
- **Admin Login:** http://127.0.0.1:8000/admin/login
- **Test Route:** http://127.0.0.1:8000/test-member

## 🎯 Common Workflows

### Initial Setup
```bash
# 1. Install dependencies
composer install && npm install

# 2. Configure environment
cp .env.example .env
php artisan key:generate
php artisan encryption:generate-key

# 3. Setup database
php artisan migrate

# 4. Create admin
php artisan admin:create

# 5. Start servers
php artisan serve
npm run dev
```

### Daily Development
```bash
# 1. Start servers
php artisan serve
npm run dev

# 2. Clear cache if needed
php artisan optimize:clear

# 3. Check routes
php artisan route:list
```

### Before Deployment
```bash
# 1. Run migrations
php artisan migrate

# 2. Build assets
npm run build

# 3. Optimize
php artisan optimize

# 4. Clear caches
php artisan optimize:clear
```

---

**Quick Reference:** Keep this file handy for daily development! 🚀

