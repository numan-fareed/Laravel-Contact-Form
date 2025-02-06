# Laravel Contact Form Project

## 🚀 Project Overview

A robust, feature-rich contact form application built with Laravel and Vue.js, designed to provide a seamless user experience with comprehensive validation and file management capabilities.

## 🌟 Key Features

- **Advanced Contact Form**
  - Detailed form with multiple input fields
  - Comprehensive client-side and server-side validation
  - File upload support (JPG images and PDF documents)

- **Technical Highlights**
  - Laravel 11.x backend
  - Vue.js 3 frontend
  - SQLite database
  - Responsive design
  - SweetAlert2 for user notifications
  - Custom Artisan commands for file management

## 🛠 Technologies Used

- **Backend**: Laravel 11.x
- **Frontend**: Vue.js 3, Bootstrap
- **Database**: SQLite
- **File Management**: Laravel Storage
- **Validation**: Custom server and client-side validation
- **Notification**: SweetAlert2

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP 8.1+
- Composer
- Node.js 16+
- npm
- Git

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/numan-fareed/Laravel-Contact-Form.git
cd Laravel-Contact-Form
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install JavaScript Dependencies
```bash
npm install
```

### 4. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Setup Database
```bash
touch database/database.sqlite
php artisan migrate
```

### 6. Compile Assets
```bash
npm run dev
```

### 7. Start Development Server
```bash
php artisan serve
```

## 📝 Form Validation Rules

- **Name**: 2-10 characters
- **Email**: 
  - Valid domain 
  - No Gmail addresses
- **Phone**: International format with country code
- **Message**: Minimum 10 characters
- **File Uploads**: 
  - Images: JPG only
  - Documents: PDF only

## 🔍 File Management

### Testing File URLs
Use the custom Artisan command to test file management:

```bash
# List recent submissions
php artisan submission:test-files

# List files for a specific submission
php artisan submission:test-files 1 --list

# Download a specific file
php artisan submission:test-files --download=images/example.jpg
```

## 🧪 Testing

Run PHP tests:
```bash
php artisan test
```

## 📦 Project Structure

```
Laravel-Contact-Form/
│
├── app/
│   ├── Console/Commands/     # Custom Artisan commands
│   ├── Http/Controllers/     # Application controllers
│   └── Models/               # Eloquent models
│
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
│
├── resources/
│   ├── js/                   # Vue.js components
│   ├── sass/                 # Styling
│   └── views/                # Blade templates
│
├── routes/                   # Application routes
└── tests/                    # Application tests
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 👥 Contact

Numan Fareed - [GitHub Profile](https://github.com/numan-fareed)

Project Link: [https://github.com/numan-fareed/Laravel-Contact-Form](https://github.com/numan-fareed/Laravel-Contact-Form)

---

**Happy Coding! 🚀**
