# LMS Admin Panel

A comprehensive administration panel for your Learning Management System built with Laravel and modern UI components.

## 🚀 Features

### 📊 Dashboard
- **Analytics Overview**: Real-time statistics for users, courses, orders, and revenue
- **Revenue Charts**: Monthly revenue tracking with Chart.js
- **Recent Activity**: Latest users, orders, and courses
- **Top Courses**: Most popular courses by enrollment

### 👥 User Management
- **User CRUD**: Create, read, update, and delete user accounts
- **Advanced Search**: Search by name, email, or phone number
- **Status Management**: Activate/deactivate user accounts
- **Bulk Actions**: Delete, activate, or deactivate multiple users
- **Export/Import**: CSV export and import functionality
- **User Analytics**: View user enrollments, orders, and activity

### 📚 Course Management
- **Course CRUD**: Full course management with categories and tags
- **Content Management**: Manage lessons, sections, and media
- **Publishing Workflow**: Draft/publish course status
- **Category Management**: Hierarchical course categories
- **Bulk Operations**: Publish multiple courses at once

### 💳 Payment & Orders
- **Order Management**: View and manage all orders
- **Payment Processing**: Track payment status and history
- **Refund Management**: Process refunds and track refund history
- **Invoice Generation**: Generate and download invoices
- **Financial Reports**: Revenue analytics and reporting

### 📧 Communications
- **Notification System**: Send bulk notifications to users
- **Email Logs**: Track email delivery and status
- **SMS Logs**: Monitor SMS delivery
- **Announcements**: Broadcast messages to specific user groups

### 🎨 Content Management
- **Page Management**: Create and manage CMS pages (legal, FAQ, etc.)
- **Banner Management**: Marketing banners with scheduling
- **Media Library**: File upload and management system

### ⚙️ Settings & API
- **API Client Management**: Manage third-party API access
- **Rate Limiting**: Configure API rate limits
- **Audit Logs**: Track all admin actions for compliance
- **System Settings**: General application configuration

## 🛠️ Installation

### Prerequisites
- PHP 8.1 or higher
- Laravel 10.x
- MySQL/PostgreSQL database
- Composer

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd edu_lms_admin
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database**
   ```bash
   php artisan db:seed
   ```

7. **Create admin user**
   ```bash
   php artisan make:dashboard
   ```

8. **Register middleware**
   Add the admin middleware to `app/Http/Kernel.php`:
   ```php
   protected $routeMiddleware = [
       // ... other middlewares
       'dashboard' => \App\Http\Middleware\AdminMiddleware::class,
   ];
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🔐 Authentication & Authorization

### Admin Access
The admin panel is protected by the `AdminMiddleware` which checks for admin privileges. You can customize the admin check in `app/Http/Middleware/AdminMiddleware.php`.

### Role-Based Access
For more granular permissions, consider using the Spatie Laravel Permission package:

```bash
composer require spatie/laravel-permission
```

Then modify the `isAdmin()` method in the middleware to use roles:

```php
private function isAdmin($user)
{
    return $user->hasRole('dashboard');
}
```

## 📁 File Structure

```
resources/views/admin/
├── layouts/
│   └── app.blade.php          # Main admin layout
├── dashboard.blade.php        # Dashboard view
├── users/
│   ├── index.blade.php        # Users list
│   ├── create.blade.php       # Create user
│   ├── edit.blade.php         # Edit user
│   └── show.blade.php         # User details
├── courses/
│   ├── index.blade.php        # Courses list
│   ├── create.blade.php       # Create course
│   ├── edit.blade.php         # Edit course
│   └── show.blade.php         # Course details
└── auth/
    └── login.blade.php        # Admin login

app/Http/Controllers/Admin/
├── DashboardController.php    # Dashboard logic
├── UserController.php         # User management
├── CourseController.php       # Course management
├── OrderController.php        # Order management
└── ...                        # Other controllers

routes/
├── admin.php                  # Admin routes
└── web.php                    # Main routes
```

## 🎨 UI Components

The admin panel uses:
- **Tailwind CSS** for styling
- **Alpine.js** for interactive components
- **Chart.js** for data visualization
- **Font Awesome** for icons

### Customization
You can customize the design by modifying the Tailwind classes in the Blade templates or by creating custom CSS.

## 📊 Database Schema

The admin panel works with the following main tables:
- `users` - User accounts and profiles
- `courses` - Course information
- `orders` - Order management
- `payments` - Payment processing
- `enrollments` - User course enrollments
- `notifications` - Communication system
- `admin_actions_audit` - Admin activity logging

## 🔧 Configuration

### Environment Variables
Add these to your `.env` file:

```env
# Admin Panel Settings
ADMIN_EMAIL=admin@example.com
ADMIN_NAME=System Administrator

# File Upload Settings
FILESYSTEM_DISK=public
MAX_FILE_SIZE=10240

# Email Settings
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Run `php artisan view:cache`
5. Set up proper file permissions
6. Configure your web server (Apache/Nginx)

### Security Considerations
- Use HTTPS in production
- Implement proper backup strategies
- Set up monitoring and logging
- Regular security updates
- Database encryption for sensitive data

## 📈 Analytics & Reporting

The admin panel includes comprehensive analytics:
- User growth tracking
- Revenue analytics
- Course performance metrics
- Enrollment statistics
- Payment processing reports

## 🔄 API Integration

The admin panel supports API client management for:
- Third-party integrations
- Mobile app access
- External service connections
- Rate limiting and monitoring

## 🆘 Support

For support and questions:
1. Check the Laravel documentation
2. Review the code comments
3. Check the GitHub issues
4. Contact the development team

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

---

**Built with ❤️ using Laravel and modern web technologies**
