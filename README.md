# BC Wine Recommender CMS Project

**Project Description:** A simple web application developed in PHP, MySQL, and HTML/CSS that allows administrators to manage British Columbia wines and provides users with a recommender interface to find wines based on criteria like colour, body, sweetness, and specific flavor notes.

## Key Features

1.  **Complete CRUD Operations**
    * Create, Read, Update, and Delete wine records
    * **Image upload and deletion** (managed during creation and editing)
    * **Relational data management** for wine flavor notes (many-to-many relationship)

2.  **User Authentication**
    * Secure **registration** and **login** system for administrators
    * Passwords securely stored using **`password_hash()`** 
    * Session-based access control to protect the `/Private` admin directory

3.  **Data Validation**
    * Server-side validation for all admin forms.
    * Required field validation for core inputs (Name, Winery, Region, etc.)
    * Price validation (numeric and positive check)
    * Secure **file upload validation** (type, size, and PHP error checking).
    * Input persistence upon validation failure

4.  **Database Integrity**
    * **Foreign Key constraints** enforce the link between `wine` and `tasting-notes`
    * **Deletion cleanup** using transactions to remove associated tasting notes before deleting the main wine record
    * Prevents orphaned data and maintains relational integrity

5.  **Security Features**
    * **Prepared Statements (PDO)** utilized for all database interaction to prevent **SQL Injection**.
    * **XSS Protection** with `html_escape()`
    * Safe file handling using unique filenames and secured file paths.

6.  **Public Filtering & UI**
    * **Relational Recommender Engine** capable of querying wines by multiple criteria (Colour, Body, Sweetness) and arrays of flavor notes.
    * Responsive design for accessibility.
    * Clear **success/error messaging** (via `$_SESSION` and form display).
    * Image previews displayed during the editing process.

## Technologies Used

- **PHP 8.1+** - Server-side scripting
- **MySQL** - Database management
- **PDO** - Database abstraction layer
- **HTML5** - Page structure
- **CSS3** - Styling and layout
- **Prepared Statements** - SQL injection prevention

## Project Structure

BC-WINE-RECOMMENDER/
├── Private/
│   ├── includes/                    
│       ├── header_private.php         # Admin dashboard header
│       └──side_nav.php                # Side navigation for Admin dashboard
│   ├── add_wine.php                   # Add wine
│   ├── dashboard.php                  # Admin dashboard
│   ├── delete-wine.php                # Delete wine
│   ├── edit-wine.php                  # Edit wine
│   ├── logout.php                     # Redirect to login
│   └── manage_wines.php               # View all wines
├── Public/
│   ├── images/                        # User uploaded wine images
│   ├── includes/                      
│       ├── config.php                 # Configuration settings
│       ├── create_first_admin.php     # Used to create first admin 
│       ├── Database.php               # Database connection & helpers
│       ├── footer.php                 # Header template
│       ├── nav.php                    # Navigation template
│       └── process_filters.php        # Process filters & redirect to recommended
│   ├── about.php                      # About page
│   ├── index.php                      # Home page
│   ├── login.php                      # Login page
│   ├── recommended.php                # Recommended wines page
│   ├── database.sql                   # Database schema & sample data
│   ├── register.php                   # New user registration
│   └── styles.css                     # CSS Styles
├── README.md                          # This file
└── wine_db.sql                        # Wine database 

## Installation

### Prerequisites
* **PHP 8.1 or higher** 
* **MySQL 5.7 or higher** (or MariaDB).
* **Apache/Nginx web server**.
* **PDO MySQL extension enabled**

### Step 1: Setup Database

1.  Create a new MySQL database:
    ```sql
    CREATE DATABASE bc_wine_recommender CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    ```

2.  Import the database schema:
    ```bash
    mysql -u root -p bc_wine_recommender < wine_db.sql
    ```
    Or use phpMyAdmin to import the **`wine_db.sql`** file.

### Step 2: Configure the Application

Edit the database connection file, **`Public/includes/Database.php`**, and update the credentials and paths:

```php
// Database Connection Credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'bc_wine_recommender');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// File Upload Path Constant (Adjust if your base path changes)
define('UPLOAD_PATH', __DIR__ . '/../images/');

### Step 3: Set Permissions

Make sure the `images/` directory is writable:

```bash
chmod 755 images/
```

### Step 4: Access the Application

Navigate to: `http://localhost/BC-WINE-RECOMMENDER/Public/`

