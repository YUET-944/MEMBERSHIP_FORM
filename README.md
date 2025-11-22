# National-Level Individual Membership System

## 🔐 High-Security Laravel + PostgreSQL Membership Platform

A government-grade membership management system with enterprise-level security, encryption, and compliance features.

---

## 🛡️ Security Features

| Security Layer | Implementation | Purpose |
|----------------|----------------|---------|
| **Data Encryption** | AES-256 | Encrypts CNIC, Email, Phone, Address, Documents |
| **Password Hashing** | Argon2id | Secure, modern password hashing |
| **Communication** | TLS 1.3 | End-to-end encrypted communication |
| **Database** | PostgreSQL RLS | Row-Level Security for data isolation |
| **Authentication** | Laravel Sanctum + 2FA | Multi-factor authentication |
| **Session Security** | HttpOnly + Secure Cookies | Prevents session hijacking |
| **Rate Limiting** | Custom Middleware | Brute force protection |
| **Input Validation** | Laravel Validation | SQL Injection & XSS prevention |
| **File Security** | Antivirus Scan + Encryption | Secure document storage |
| **Audit Logging** | Immutable Logs | Complete activity tracking |

---

## 📋 Requirements

- PHP >= 8.2
- PostgreSQL >= 14.0
- Composer
- Node.js >= 18.0
- OpenSSL extension
- BCMath extension

---

## 🚀 Installation

### 1. Clone and Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

### 3. Database Setup

```bash
# Configure .env with PostgreSQL credentials
php artisan migrate
php artisan db:seed
```

### 4. Generate Encryption Keys

```bash
php artisan encryption:generate-keys
```

### 5. Start Development Server

```bash
php artisan serve
npm run dev
```

---

## 📁 Project Structure

```
membership-form/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Member/
│   │   │   └── Admin/
│   │   ├── Middleware/
│   │   │   ├── EncryptionMiddleware.php
│   │   │   ├── SecurityHeaders.php
│   │   │   └── RateLimitMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── Member.php
│   │   ├── OtpVerification.php
│   │   └── SecurityLog.php
│   ├── Services/
│   │   ├── EncryptionService.php
│   │   ├── OtpService.php
│   │   ├── TwoFactorService.php
│   │   └── CertificateService.php
│   └── Traits/
│       └── EncryptsAttributes.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── admin.php
├── tests/
│   ├── Feature/
│   └── Unit/
└── docs/
    ├── API.md
    ├── SECURITY.md
    └── DEPLOYMENT.md
```

---

## 🔑 Key Features

### Membership Registration
- Multi-step secure form
- CNIC-based gender/region detection
- Document upload with encryption
- OTP verification (Email + SMS)
- Automatic membership ID generation

### Admin Panel
- Role-Based Access Control (RBAC)
- Member approval/rejection
- Document verification
- PDF certificate generation with QR codes
- Comprehensive audit logs

### Member Dashboard
- Profile management
- Certificate download
- Membership renewal
- Document updates
- Activity history

---

## 🔒 Security Best Practices

1. **Never commit `.env` file**
2. **Rotate encryption keys regularly**
3. **Use HTTPS in production**
4. **Enable PostgreSQL RLS policies**
5. **Monitor security logs daily**
6. **Keep dependencies updated**
7. **Regular security audits**

---

## 📚 Documentation

- [API Documentation](docs/API.md)
- [Security Guide](docs/SECURITY.md)
- [Deployment Guide](docs/DEPLOYMENT.md)

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run security tests
php artisan test --filter Security

# Run with coverage
php artisan test --coverage
```

---

## 📝 License

MIT License - See LICENSE file for details

---

## 👥 Support

For security issues, please contact the security team directly.

---

**Built with ❤️ for National-Level Security Standards**

