# 🧪 Testing Guide

## ✅ Quick Test Methods

### Method 1: Browser Test (Easiest)

1. **Start the server:**
   ```bash
   php artisan serve
   ```

2. **Visit test URL:**
   ```
   http://127.0.0.1:8000/test-member
   ```

3. **Expected Response:**
   ```json
   {
     "success": true,
     "database": "✅ Connected",
     "model_test": "✅ Passed",
     "full_name_auto_generated": "Test User",
     "membership_id_auto_generated": "IND-20241120-XXXXXX",
     "message": "All tests passed! Model is working correctly."
   }
   ```

### Method 2: Artisan Tinker (Interactive)

```bash
php artisan tinker
```

Then run:
```php
// Test database connection
DB::connection()->getPdo();
// Should return: PDO object

// Test Member creation
$member = new App\Models\Member();
$member->first_name = 'Test';
$member->last_name = 'User';
$member->email = 'test@example.com';
$member->password = bcrypt('password');
$member->save();

// Check auto-generated fields
echo $member->full_name; // Should show: "Test User"
echo $member->membership_id; // Should show: "IND-YYYYMMDD-XXXXXX"

// Clean up
$member->delete();
```

### Method 3: cURL Test

```bash
curl http://127.0.0.1:8000/test-member
```

## ✅ What Gets Tested

1. **Database Connection** - Verifies PostgreSQL connection
2. **Member Model** - Tests model creation
3. **Auto-full_name** - Verifies `full_name` is auto-populated
4. **Auto-membership_id** - Verifies membership ID generation
5. **Model Saving** - Tests database insert
6. **Model Deletion** - Tests cleanup

## 🔧 Troubleshooting

### If Test Fails:

1. **Check Database Connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

2. **Check Migrations:**
   ```bash
   php artisan migrate:status
   ```

3. **Check .env Configuration:**
   ```bash
   # Make sure these are set:
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=membership_db
   DB_USERNAME=postgres
   DB_PASSWORD=your_password
   ```

4. **Clear Cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## 🚀 Production Note

**Remove the test route before deploying to production!**

The test route is at:
- `routes/web.php` - Line with `Route::get('/test-member', ...)`

Simply delete or comment it out before going live.

## ✅ Expected Results

When everything is working correctly, you should see:

- ✅ Database connection successful
- ✅ Member model creates successfully
- ✅ `full_name` = "Test User" (auto-generated)
- ✅ `membership_id` = "IND-YYYYMMDD-XXXXXX" (auto-generated)
- ✅ Test member deleted successfully

---

**Quick Test Command:**
```bash
php artisan serve
# Then visit: http://127.0.0.1:8000/test-member
```

