# Laravel Contact Form Project

## Project Overview
This is a Laravel-based web application featuring a comprehensive contact form with advanced validation, file upload capabilities, and robust file management.

## Features
- Detailed contact form with multiple fields
- Client-side and server-side validation
- File upload support (JPG images and PDF files)
- Responsive Vue.js frontend
- SQLite database integration
- Advanced file testing and management

## Prerequisites
- PHP 8.1+
- Composer
- Node.js and npm
- Laravel 11.x

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/laravel-contact-form.git
cd laravel-contact-form
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

### 5. Configure Database
Edit `.env` file to set up your database connection. For SQLite:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Create the SQLite database:
```bash
touch database/database.sqlite
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Compile Assets
```bash
npm run dev
```

### 9. Start Development Server
```bash
php artisan serve
```

## Running the Application
Open your browser and navigate to `http://localhost:8000`

## Form Validation Rules
- Name: 2-10 characters
- Email: Valid domain (no Gmail)
- Phone: International format with country code
- Message: Minimum 10 characters
- File uploads: 
  - Images: JPG only
  - Documents: PDF only

## File Management and Testing

### Submission File Testing
Use the custom Artisan command to test file URLs and downloads:

#### List Recent Submissions
```bash
php artisan submission:test-files
```

#### List Files for a Specific Submission
```bash
php artisan submission:test-files 1 --list
```

#### Download a Specific File
```bash
php artisan submission:test-files --download=images/your-image.jpg
```

### File Storage
- Files are stored in `storage/app/public/Files`
- Supports separate storage for images and documents
- Provides URL generation and download capabilities

## Advanced Features
- Comprehensive form validation
- SweetAlert2 for user-friendly notifications
- Responsive design
- File upload and management

## Troubleshooting
- Ensure all dependencies are installed
- Check file permissions for storage and database
- Verify `.env` configuration
- Use Artisan commands for file testing and debugging

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)

### Development Notes
- Frontend built with Vue.js
- Backend powered by Laravel
- SQLite database for lightweight storage
- Comprehensive validation on both client and server sides
