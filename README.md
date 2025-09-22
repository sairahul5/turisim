# Tourism Search Application - Setup Guide

## 🚀 Complete Tourism/Homestay Search Application

This application allows users to search for homestays and tourist locations by city name using a secure PHP/MySQL backend.

## 📁 Files Generated:

1. **schema.sql** - Database setup and sample data
2. **search_index.html** - Main search interface
3. **style.css** - Tourism-themed styling
4. **search.php** - Secure PHP search backend

## 🔧 Setup Instructions:

### 1. Database Setup
```bash
# Login to MySQL
mysql -u root -p

# Run the schema file
source schema.sql
```

### 2. Configure Database Connection
Edit `search.php` and update these constants:
```php
define('DB_SERVER', 'localhost');
define('DB_USER', 'your_mysql_username');
define('DB_PASSWORD', 'your_mysql_password');
define('DB_NAME', 'tourism_search_db');
```

### 3. Web Server Setup
- Place all files in your web server directory (e.g., `/var/www/html/` or `htdocs/`)
- Ensure PHP and MySQL are installed and running
- Access via: `http://localhost/search_index.html`

## 🔍 Features:

✅ **Security**: Uses prepared statements to prevent SQL injection
✅ **Search**: LIKE operator for flexible city name matching
✅ **Organization**: Results grouped by Homestays and Locations
✅ **Responsive**: Mobile-friendly tourism-themed design
✅ **Validation**: Input sanitization and error handling

## 🎯 Test Searches:

- Search "Goa" - Shows beach homestays and spice gardens
- Search "Delhi" - Shows heritage homestays and historical locations
- Search "Mumbai" - Shows no results message

## 📊 Database Structure:

The `places` table contains:
- **id**: Auto-increment primary key
- **name**: Place/homestay name
- **type**: Either 'Homestay' or 'Location'
- **city**: Search field (Goa, Delhi, etc.)
- **description**: Detailed information

## 🎨 Design Features:

- Ocean blue gradient background (#e3f2fd to #bbdefb)
- White card-based results layout
- Green accent buttons (#4caf50)
- Responsive design for mobile devices
- Hover effects and smooth transitions

## 🔒 Security Features:

- Prepared statements with parameter binding
- Input sanitization and validation
- HTML entity encoding for output
- Error handling for database connections

The application is now ready to use! Simply open `search_index.html` in your browser and start searching for tourism locations.