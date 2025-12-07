# PLV Cloud

<p align="center">
  <img src="public/assets/images/logo.svg" width="120" alt="PLV Cloud Logo">
</p>

<p align="center">
  <strong>A Modern Cloud Storage Platform for Educational Institutions</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#installation">Installation</a> •
  <a href="#configuration">Configuration</a> •
  <a href="#deployment">Deployment</a> •
  <a href="#license">License</a>
</p>

---

## 📋 Overview

**PLV Cloud** is a comprehensive cloud storage and file management system designed specifically for educational institutions. Built with Laravel 11 and Livewire, it provides a secure, intuitive platform for students and faculty to store, organize, share, and collaborate on academic files and resources.

**Live Demo:** [https://plvcloud.onrender.com](https://plvcloud.onrender.com)

---

## ✨ Features

### 🔐 Authentication & Authorization

-   **Email Verification System** with queue-based delivery via Brevo API (<500ms send time)
-   **Session-Based Authentication** with secure password hashing
-   **Role-Based Access Control** (Admin, User)
-   **Profile Management** with Cloudinary-hosted profile pictures

### 📁 File Management

-   **Cloud Storage Integration** with Cloudinary
    -   Unlimited storage capacity through cloud infrastructure
    -   Automatic file optimization and CDN delivery
    -   Support for all file types (documents, images, videos, archives)
-   **Hierarchical Folder Structure**
    -   Create nested folders with unlimited depth
    -   Drag-and-drop file uploads
    -   Bulk file operations (upload, download, delete)
-   **Smart Search & Filtering**
    -   Real-time search across files and folders
    -   Filter by course, date, file type
    -   Advanced search with multiple criteria

### 👥 Collaboration Features

-   **Folder Sharing System**
    -   Public folders (view-only access for all users)
    -   Private folders (owner and contributors only)
    -   Contributor management with granular permissions
-   **Automatic Contributor Assignment**
    -   Users who upload to public folders become contributors automatically
    -   Track file ownership and contributions
-   **Activity Logging**
    -   Comprehensive audit trail of all file operations
    -   Track uploads, downloads, shares, and deletions
    -   User activity dashboard

### 📊 Organization Tools

-   **Course Management**
    -   Link files and folders to specific courses
    -   Browse content by academic course
    -   Integrated course catalog
-   **Favorites System**
    -   Bookmark important files and folders
    -   Quick access to frequently used resources
-   **Recent Files**
    -   Track recently accessed documents
    -   Time-based activity filtering

### 🔔 Notifications

-   **Real-Time Notification System**
    -   File share notifications
    -   Folder access requests
    -   System announcements
-   **In-App Notification Center**
    -   Read/unread status tracking
    -   Notification history
    -   Action buttons for quick responses

### 📱 User Experience

-   **Responsive Design** optimized for desktop, tablet, and mobile
-   **Intuitive UI/UX** with smooth transitions and animations
-   **Fast Performance** with optimized database queries and caching
-   **Progressive Web App** capabilities for offline access

### 🛡️ Security Features

-   **CSRF Protection** on all forms
-   **SQL Injection Prevention** through Eloquent ORM
-   **XSS Protection** with Laravel's Blade templating
-   **Secure File Storage** with Cloudinary's infrastructure
-   **Email Verification** required for account activation
-   **Session Management** with automatic logout

---

## 🚀 Tech Stack

### Backend

-   **Laravel 11** - Modern PHP framework with elegant syntax
-   **Livewire 3** - Full-stack reactive framework for dynamic interfaces
-   **PostgreSQL** - Robust relational database for production
-   **Queue System** - Database-driven job processing for async tasks

### Frontend

-   **Tailwind CSS 3** - Utility-first CSS framework
-   **Alpine.js** - Lightweight JavaScript framework for interactivity
-   **Vite 7** - Next-generation frontend tooling
-   **Custom Fonts** - Poppins for modern typography

### Cloud Services

-   **Cloudinary** - Media management and CDN
    -   Image optimization and transformations
    -   Video streaming and processing
    -   Automatic backup and redundancy
-   **Brevo (Sendinblue)** - Transactional email delivery
    -   API-based sending (400ms average delivery)
    -   300 emails/day free tier
    -   Delivery tracking and analytics

### DevOps & Deployment

-   **Docker** - Containerized production environment
-   **Nginx** - High-performance web server
-   **Supervisor** - Process management for queues and workers
-   **Render.com** - Cloud hosting platform with auto-deployment
-   **GitHub Actions** - CI/CD pipeline (secret scanning enabled)

### Development Tools

-   **Laravel Debugbar** - Development debugging and profiling
-   **Laravel Pail** - Real-time log monitoring
-   **Composer** - PHP dependency management
-   **NPM** - JavaScript package management

---

## 📦 Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer 2.x
-   Node.js 18.x or higher
-   PostgreSQL 14+ or MySQL 8.0+
-   Git

### Local Development Setup

1. **Clone the repository**

```bash
git clone https://github.com/RusselxD/plv-cloud.git
cd plv-cloud
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Environment configuration**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure your `.env` file**

```env
APP_NAME="PLV Cloud"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=plv_cloud_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cloudinary
CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name

# Brevo API
MAIL_MAILER=brevo-api
BREVO_API_KEY=your_brevo_api_key
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"

# Queue
QUEUE_CONNECTION=database

# Admin Credentials
ADMIN_USERNAME=admin
ADMIN_PASSWORD=your_secure_password
```

6. **Run database migrations and seeders**

```bash
php artisan migrate --seed
```

7. **Build frontend assets**

```bash
npm run build
# Or for development with hot reload:
npm run dev
```

8. **Start the development server**

```bash
php artisan serve
```

9. **Start the queue worker** (in a separate terminal)

```bash
php artisan queue:work --verbose
```

10. **Access the application**

-   Navigate to `http://localhost:8000`
-   Register a new account or use admin credentials

---

## ⚙️ Configuration

### Cloudinary Setup

1. Create a free account at [cloudinary.com](https://cloudinary.com)
2. Get your Cloud Name, API Key, and API Secret from the dashboard
3. Add to `.env`: `CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name`

### Brevo Email Setup

1. Sign up at [brevo.com](https://www.brevo.com)
2. Generate an API key from Settings → SMTP & API → API Keys
3. Add to `.env`: `BREVO_API_KEY=xkeysib-your_api_key`
4. Verify your sender email address in Brevo dashboard

### Course Seeding

The application comes with pre-configured courses. To customize:

```bash
# Edit database/seeders/CourseSeeder.php
php artisan db:seed --class=CourseSeeder
```

### Admin Account

Set admin credentials in `.env`:

```env
ADMIN_USERNAME=your_admin_username
ADMIN_PASSWORD=your_secure_password
```

---

## 🚢 Deployment

### Production Deployment (Render.com)

The application is configured for automatic deployment on Render.com via `render.yaml`.

**Prerequisites:**

-   Render.com account
-   PostgreSQL database provisioned on Render
-   GitHub repository connected to Render

**Environment Variables to Set:**

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.onrender.com
DATABASE_URL=(auto-generated by Render PostgreSQL)
CLOUDINARY_URL=cloudinary://your_credentials
BREVO_API_KEY=your_api_key
QUEUE_CONNECTION=database
MAIL_MAILER=brevo-api
```

**Deployment Process:**

1. Push to main branch triggers automatic deployment
2. Docker image is built with all dependencies
3. Supervisor manages PHP-FPM, Nginx, and queue workers
4. Database migrations run automatically
5. Assets are pre-compiled during build

**Docker Configuration:**

-   **Web Server:** Nginx on port 8080
-   **PHP-FPM:** FastCGI process manager
-   **Queue Worker:** Laravel queue:work with 180s timeout
-   **Process Manager:** Supervisord for reliability

### Manual Deployment

1. **Set environment to production**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

2. **Set proper permissions**

```bash
chmod -R 775 storage bootstrap/cache
```

3. **Configure web server** (Nginx example)

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/plv-cloud/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

4. **Set up queue worker** (Supervisor)

```ini
[program:plv-cloud-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/plv-cloud/artisan queue:work database --sleep=3 --tries=3 --timeout=180
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/plv-cloud/storage/logs/worker.log
```

---

## 🏗️ Architecture

### Directory Structure

```
plv-cloud/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # HTTP request handlers
│   │   └── Middleware/      # Request filtering
│   ├── Livewire/           # Livewire components
│   │   ├── Auth/           # Authentication components
│   │   ├── Component/      # Reusable UI components
│   │   └── Page/           # Full-page components
│   ├── Mail/               # Email classes and transport
│   ├── Models/             # Eloquent ORM models
│   └── Providers/          # Service providers
├── config/                 # Configuration files
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Data seeders
├── docker/                # Docker configuration
├── public/                # Public assets
├── resources/
│   ├── css/               # Tailwind CSS
│   ├── js/                # JavaScript files
│   └── views/             # Blade templates
├── routes/                # Application routes
├── storage/               # File storage and logs
└── tests/                 # Test suites
```

### Database Schema

-   **users** - User accounts and profiles
-   **courses** - Course catalog
-   **folders** - Hierarchical folder structure
-   **files** - File metadata (actual files in Cloudinary)
-   **folder_contributors** - Collaboration permissions
-   **folder_requests** - Access request management
-   **saves** - User favorites
-   **notifications** - In-app notification system
-   **user_activities** - Activity logging and audit trail
-   **reports** - Content reporting system
-   **email_verifications** - Email verification tokens
-   **jobs** - Queue system job tracking

---

## 🔧 Key Components

### Custom Brevo API Transport

Located in `app/Mail/BrevoApiTransport.php`, this custom implementation provides:

-   Direct API integration with Brevo (bypassing slow SMTP)
-   10x faster email delivery (400ms vs 4000ms with SMTP)
-   Automatic retry handling
-   Detailed logging for debugging

### Cloudinary Integration

-   **File Uploads:** `app/Livewire/Component/AddNewButton.php`
-   **Profile Pictures:** `app/Livewire/Page/User.php`
-   **File Deletion:** `app/Livewire/Component/ConfirmDeleteModal.php`
-   **Downloads:** `app/Http/Controllers/FileController.php`

### Queue System

-   **Driver:** Database (configurable to Redis/SQS for scaling)
-   **Jobs:** Email sending, file processing, notifications
-   **Monitoring:** Real-time job status in queue dashboard
-   **Failure Handling:** Automatic retry with exponential backoff

---

## 🧪 Testing

### Run Test Suite

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Email Delivery

```bash
# Test Brevo API speed
php test-brevo-api.php

# Test SMTP speed (for comparison)
php test-speed.php
```

---

## 📊 Performance Benchmarks

### Email Delivery

-   **Brevo API:** 400ms average
-   **SMTP (Gmail):** 2,300ms average
-   **SMTP (Brevo):** 2,270ms average
-   **Improvement:** 5.7x faster with API

### Page Load Times

-   **Dashboard:** <200ms (cached)
-   **File Upload:** 500ms (small files)
-   **Search Results:** <150ms
-   **File Download:** Depends on file size + CDN delivery

---

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Style

-   Follow PSR-12 coding standards
-   Use meaningful variable and function names
-   Add comments for complex logic
-   Write tests for new features

---

## 🐛 Known Issues

-   Email deliverability may vary by recipient's spam filters (check spam folder)
-   Cloudinary free tier has bandwidth limits (upgrade for production use)
-   Queue workers must be running for background jobs

---

## 📝 Changelog

### Version 1.0.0 (Current)

-   Initial release with core functionality
-   Cloudinary integration for file storage
-   Brevo API for email delivery
-   Queue-based job processing
-   Responsive UI
-   Comprehensive notification system

---

## 📜 License

This project is proprietary software. All rights reserved.

**© 2025 PLV Cloud. Built for Pamantasan ng Lungsod ng Valenzuela.**

---

## 👨‍💻 Developer

**Russel Cabigquez**

-   GitHub: [@RusselxD](https://github.com/RusselxD)
-   Email: russelcabigquez8@gmail.com

---

## 🙏 Acknowledgments

-   **Laravel Team** - For the amazing framework
-   **Livewire Team** - For reactive components
-   **Cloudinary** - For cloud storage infrastructure
-   **Brevo** - For reliable email delivery
-   **Tailwind Labs** - For utility-first CSS
-   **Render.com** - For seamless hosting
