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

## Usage Guide

### Managing Wine Catalogue

This section covers the CRUD operations for the wine records, including image and tasting note management.

#### List Wines
* Navigate to **Admin > Manage Wines**.
* View all wines listed with the Name, Colour, Price, and edit and delete actions.
* Click **EDIT** to modify a wine's profile, image, and tasting notes.
* Click **DELETE** to permanently remove a wine record.

#### Create New Wine
1.  Click the **"ADD NEW WINE"** button.
2.  Enter mandatory **Product Information** (Name, Winery, Region, Description).
3.  Upload an image file for the wine label (optional, but recommended).
4.  Enter the **Recommendation Filters** (Colour, Body, Sweetness, Price).
5.  Select all applicable **Tasting Notes** (flavor profiles) from the grid.
6.  Click **"SAVE NEW WINE"**.

#### Edit Wine
1.  Click the **EDIT** button on any wine from the list.
2.  Modify any text fields, dropdown selections, or price.
3.  To change the image, click **"Choose File"** and upload a new image; the system will automatically **delete the old image file** upon successful update.
4.  Modify the **Tasting Notes** by checking/unchecking the relevant checkboxes.
5.  Click **"Save Wine Profile Changes"**.

#### Delete Wine
1.  Click the **DELETE** button next to the desired wine.
2.  Confirm the deletion.
3.  The main wine record, along with **all associated tasting notes** and the physical image file will be automatically deleted due to the database integrity setup.

---

### Managing User Accounts

This section covers the registration and access features for administrators.

#### Register a New Admin
1.  Navigate to the **`/Public/register.php`** URL.
2.  Enter a unique **Username**.
3.  Enter and confirm a strong **Password** (minimum 8 characters).
4.  Click **"Register"**.

#### Accessing the Admin Panel
1.  Navigate to **`/Public/login.php`**.
2.  Enter your registered Username and Password.
3.  Click **"Log In"** to be redirected to the **Dashboard**.

#### Logging Out
* Click the **"Log Out"** link (usually located in the navigation bar) to clear your session and return to the login screen.

## Key Concepts Demonstrated

### 1. Prepared Statements (PDO)

This technique prevents SQL Injection by sending the query structure and the data to the database separately.

```php
// Example from edit-wine.php (using positional placeholders)
$sql_wine_update = "
    UPDATE wine SET 
        name = ?, winery = ?, region = ?, colour = ?, body = ?, 
        sweetness = ?, price = ?, description = ?, image_url = ?
    WHERE wine_id = ?
";
// ... execution follows using executePS($pdo, $sql_wine_update, $params_wine_update);

### 2. Getting Last Insert ID

* Used in `add-wine.php` to retrieve the automatically generated `wine_id` after inserting the new wine record, which is necessary for immediately linking the tasting notes in the next step.

### 3. Counting Affected Rows

* Used in the authentication and login process to verify that exactly one row (the admin user) matches the provided credentials.

### 4. Handling Database Transactions and Errors

* **Database Transactions:** Implemented in `edit-wine.php` and `delete-wine.php` to guarantee that multi-step operations (e.g., deleting notes AND deleting wine) either fully succeed or fully fail (`COMMIT` or `ROLLBACK`), ensuring data integrity.
* **Duplicate Handling:** The specific `try...catch` logic is used in `register.php` (and should be used in `add-wine.php`) to catch database errors (like unique constraint violations) and display a user-friendly error message instead of crashing.

### 5. Form Validation Flow

* The code follows the sequential flow of checking conditions: check for `$_GET` ID, check for `$_POST` submission, validate data, process database operations if no errors, and finally, display errors or redirect. This ensures user input is retained on failure.

### 6. File Upload Handling

* Robust logic in `edit-wine.php` ensures files are checked for type and size, given a unique filename to prevent collisions, and the old file is safely deleted when replaced.

## Wine Database Schema

### `wine` table

* `id` - **Primary key **
* `name` - Name of the wine
* `winery` - Winery name
* `colour` - Colour of wine
* `body` - Body of wine
* `sweetness` - Sweetness of wine
* `description` - Brief description of wine
* `image_url` - Image url
* `updated_at` - Timestamp of last update

### `tasting_note` table

* `note_id` - **Primary key **
* `wine_id` - **Foreign key ** to `wine` table. Links the note to a specific wine
* `flavour_note` - Flavour notes of wine

### `admin` table

* `id` - **Primary key **
* `username` - Unique login username
* `password` - Securely stored password

## Security Features

### 1. SQL Injection Prevention

* All database queries use prepared statements
* No direct SQL string concatenation

### 2. XSS (Cross-Site Scripting) Prevention

* All output rendered to the user is passed through escaping functions.
* Using the native `htmlspecialchars()` function and/or a custom `html_escape()` helper function

### 3. File Upload Security

* Validation of file extension and size limits
* Generation of a unique filename for storage

### 4. Storing passwords safely

* Password Hashing

## Sample Data

The database includes sample data:
* 14 sample wine records
* The related flavour notes for the 14 wines
* 3 admin users

## Troubleshooting Guide

### 1. Database Connection

* Check database credentials (`config.php`)
* Ensure MySQL service is running
* Verify the database exists

### 2. Image Upload Issues

* Check `uploads/` directory permissions (should be writable, e.g., `755`).
* Verify PHP limits in `php.ini`: `upload_max_filesize` and `post_max_size`

### 3. Blank Page / PHP Error

* **Enable error reporting** in development mode (`config.php`)
* Check **PHP error logs** for the fatal error message
* Ensure **PHP PDO MySQL extension** is installed
