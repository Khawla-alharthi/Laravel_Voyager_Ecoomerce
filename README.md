# Laravel Voyager E-commerce

A modern, full-featured e-commerce application built with Laravel and Voyager admin panel. This project provides a complete online shopping solution with a powerful backend management system.

## 🚀 Features

### Frontend Features
- **Product Catalog**: Browse products by categories with advanced filtering and search
- **Shopping Cart**: Add, remove, and manage items with persistent cart storage
- **User Authentication**: Register, login, and manage user profiles
- **Order Management**: Place orders, track status, and view order history
- **Payment Integration**: Secure payment processing (Stripe/PayPal)
- **Responsive Design**: Mobile-first, responsive user interface
- **Product Reviews**: Rate and review products
- **Wishlist**: Save favorite products for later

### Admin Panel (Voyager)
- **Dashboard**: Overview of sales, orders, and key metrics
- **Product Management**: CRUD operations for products, categories, and attributes
- **Order Management**: View, process, and update order statuses
- **User Management**: Manage customers and their accounts
- **Content Management**: Manage pages, posts, and media files
- **Media Manager**: Upload and organize product images and assets
- **Settings**: Configure site settings, payment methods, and shipping options
- **Reports**: Sales reports and analytics

## 🛠 Tech Stack

- **Framework**: Laravel 10.x
- **Admin Panel**: Voyager
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade Templates, Bootstrap/Tailwind CSS
- **Authentication**: Laravel Breeze/Jetstream
- **Payment**: Stripe API
- **File Storage**: Laravel Storage (Local/S3)
- **Mail**: Laravel Mail with SMTP

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- NPM/Yarn
- MySQL >= 5.7 or PostgreSQL >= 9.6
- Git

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/Khawla-alharthi/Laravel_Voyager_Ecoomerce.git
cd Laravel_Voyager_Ecoomerce
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Configure Mail Settings
```env
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yoursite.com
```

### 6. Configure Payment (Stripe)
```env
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

### 7. Run Migrations and Seed Database
```bash
# Run migrations
php artisan migrate

# Install Voyager
php artisan voyager:install

# Create admin user
php artisan voyager:admin your@email.com --create

# Seed sample data (optional)
php artisan db:seed
```

### 8. Build Frontend Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 9. Create Storage Link
```bash
php artisan storage:link
```

### 10. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to view the application.
Admin panel is available at `http://localhost:8000/admin`.

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Mail/
│   └── Services/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php
│   └── api.php
├── public/
└── storage/
```

## 🎯 Usage

### Admin Panel
1. Login to admin panel at `/admin`
2. Manage products, categories, and orders
3. Configure site settings and payment methods
4. Monitor sales and generate reports

### Frontend
1. Browse products and categories
2. Add items to cart and checkout
3. Register/login to track orders
4. Leave reviews and manage wishlist

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure production database
4. Set up SSL certificate
5. Configure web server (Apache/Nginx)

### Optimization Commands
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 API Documentation

API endpoints are available for mobile app integration:

- `GET /api/products` - Get all products
- `GET /api/categories` - Get all categories
- `POST /api/orders` - Create new order
- `GET /api/user/orders` - Get user orders

## 🔒 Security

- All user inputs are validated and sanitized
- CSRF protection enabled
- Password hashing with bcrypt
- Secure payment processing
- Regular security updates

## 📄 License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

## 👥 Support

For support and questions:
- Create an issue on GitHub
- Email: [alharthikhawla@gmail.com]

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP framework
- [Voyager](https://voyager.devdojo.com/) - Laravel admin package
- [Stripe](https://stripe.com/) - Payment processing
- All contributors and supporters

---

**Built with ❤️ using Laravel and Voyager**
