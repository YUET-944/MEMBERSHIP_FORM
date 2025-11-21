# Deployment Instructions for Hostinger hPanel

## Prerequisites
- A Hostinger hosting account with hPanel access
- A domain name (optional, can use Hostinger's free subdomain)
- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer installed on your local machine

## Step 1: Prepare Your Application Locally

1. **Install Dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

2. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

3. **Optimize Performance**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Step 2: Upload Files to Hostinger

1. **Access hPanel**
   - Log in to your Hostinger account
   - Go to the hPanel dashboard

2. **Upload Files**
   - Navigate to "Files" → "File Manager"
   - Select your domain or subdomain
   - Delete the default files in the `public_html` directory (if any)
   - Upload all your Laravel project files to the `public_html` directory
   - OR use Git deployment (recommended):
     - Go to "Websites" → "Manage" → "Git"
     - Connect your repository and deploy

## Step 3: Configure Database

1. **Create Database**
   - In hPanel, go to "Databases" → "MySQL"
   - Create a new database
   - Note the database name, username, and password

2. **Update Environment Variables**
   - Edit the `.env` file in your project root
   - Update the database configuration:
     ```
     DB_CONNECTION=mysql
     DB_HOST=your_hostinger_db_host
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_username
     DB_PASSWORD=your_database_password
     ```

## Step 4: Set Up Public Directory

1. **Configure Document Root**
   - In hPanel, go to "Websites" → "Manage" → "Domains"
   - Click "Manage" next to your domain
   - Set the document root to `/public_html/public`

## Step 5: Run Migrations and Seeders

1. **Access SSH**
   - In hPanel, go to "Advanced" → "SSH Access"
   - Enable SSH access if not already enabled
   - Connect via SSH client

2. **Run Commands**
   ```bash
   cd /home/your_username/domains/yourdomain.com/public_html
   php artisan migrate --force
   php artisan db:seed --force
   ```

## Step 6: Set Permissions

1. **Set Correct Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

## Step 7: Configure Cron Jobs (Optional)

1. **Set Up Task Scheduling**
   - In hPanel, go to "Advanced" → "Cron Jobs"
   - Add a new cron job:
     ```
     * * * * * cd /home/your_username/domains/yourdomain.com/public_html && php artisan schedule:run >> /dev/null 2>&1
     ```

## Step 8: Final Checks

1. **Test Your Application**
   - Visit your domain in a web browser
   - Verify all pages load correctly
   - Test the contact form
   - Check admin panel access

2. **Security Considerations**
   - Ensure the `.env` file is not accessible via web
   - Verify `storage` and `bootstrap/cache` directories are not web-accessible
   - Set proper file permissions

## Troubleshooting

1. **500 Internal Server Error**
   - Check file permissions
   - Verify `.env` configuration
   - Check error logs in hPanel

2. **Database Connection Error**
   - Double-check database credentials
   - Ensure database user has proper permissions
   - Verify database host (usually localhost or 127.0.0.1)

3. **404 Not Found**
   - Verify document root is set to `/public`
   - Check if mod_rewrite is enabled
   - Confirm .htaccess file exists in public directory

## Additional Notes

- Hostinger provides one-click Laravel installation which can simplify the process
- For better performance, consider using Hostinger's caching features
- Regularly backup your database and files
- Monitor your application's error logs for any issues