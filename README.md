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

