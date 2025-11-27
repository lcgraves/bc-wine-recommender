# BC Wine Recommender CMS Project

**Project Description:** A simple web application developed in PHP, MySQL, and HTML/CSS that allows administrators to manage British Columbia wines and provides users with a recommender interface to find wines based on criteria like colour, body, sweetness, and specific flavor notes.

## Key Features

* **Secure Admin Interface:** Protected login area for CRUD (Create, Read, Update, Delete) operations on the wine catalogue.
* **User Registration/Authentication:** Secure registration and login for multiple admin users using **PHP's `password_hash()`** function.
* **Dynamic Catalogue Management:** Administrators can add, edit, and delete wine records, including image uploads and tasting note selection.
* **Relational Data Handling:** Uses two interconnected database tables (`wine` and `tasting-notes`) to manage the many-to-many relationship between a wine and its flavor notes.
* **Filtering/Search Logic:** Implements complex SQL `WHERE` clauses (e.g., using `JOIN` or `IN` clauses) to handle user-selected filters, allowing recommendations based on multiple criteria.

---