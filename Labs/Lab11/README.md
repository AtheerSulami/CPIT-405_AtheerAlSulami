# CPIT 405 — Lab 11: Ajax (DOM, XML, JSON, PHP)

**Student:** Atheer AlSulami  
**Student ID:** 2307149  
**Assignment:** [CPIT 405 Lab 11](https://cpit405.gitlab.io/labs/lab-11/)

## What is included

### Lab Assessment

1. PHP associative array keyed by names: `['Mohammad' => 4, 'Fahad' => 3.5]`, in `models/AssessmentModel.php`.
2. Conversion to JSON using PHP `json_encode()`, in `controllers/assessment.php`.
3. JavaScript Ajax `fetch()` call from `js/script1.js` to the PHP endpoint. Click **Request JSON** to display the JSON in the page and in **Developer Tools → Console**.

### Further lab objectives
- The **Request XML** button fetches an XML document generated with PHP and parses it with `DOMParser`.
- Both GET and POST Ajax requests are demonstrated.
- A homework project feature (Student Grade Manager) runs through `views`, `controllers`, `models`, and a MariaDB database.

### Homework workflow
Click **Refresh** → JS Fetch GET → `controllers/grades.php` → `models/GradeModel.php` → MariaDB → PHP JSON → DOM table.  
Click **Add**, **Save** or **Delete** → JS Fetch POST with CSRF token → PHP controller validation → model SQL prepared statement → MariaDB → refreshed JSON → DOM update, **without a page reload**.  
A message is shown if any request fails.

## Run locally

**Important:** GitHub Pages cannot execute PHP or MariaDB. Use XAMPP (Apache + PHP + MariaDB), or a system PHP server and MariaDB.

1. Install/start PHP 8.1+, the PDO MySQL extension, and MariaDB/MySQL. Import `Documents/db-install-statements.sql`:
   ```bash
   cd Labs/Lab11
   mysql -u root -p < Documents/db-install-statements.sql
   ```
2. If necessary, configure `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` as environment variables. Defaults are `127.0.0.1`, `3306`, `cpit405_lab11`, `root`, and empty password (for local test environments only).
3. From the repository root:
   ```bash
   php -S 127.0.0.1:8000 -t Labs/Lab11
   ```
4. Open **http://127.0.0.1:8000/**. The front controller redirects to `controllers/index.php`. Open Developer Tools (F12) → **Console** and click **Request JSON**. Test the database table's AJAX CRUD after importing the SQL.

For XAMPP, place `Labs/Lab11` inside `htdocs` and access `http://localhost/Lab11/`.

## Submission folder

```text
Labs/Lab11/
├── index.php
├── views/
│   └── page1.php
├── css/
│   └── style.css
├── js/
│   └── script1.js
├── controllers/
│   ├── index.php
│   ├── assessment.php
│   ├── xml.php
│   └── grades.php
├── models/
│   ├── AssessmentModel.php
│   ├── Database.php
│   └── GradeModel.php
└── Documents/
    ├── db-install-statements.sql
    ├── project-sketch.pdf
    └── project-description.pdf
```

## Notes

- The JS file starts with the student's name and ID in a comment, as requested.
- Stored SQL values use parameterized prepared statements; data is added to the DOM through safe text content; POST writes use a CSRF token.
- This project is a local lab implementation. It is not deployed to a working PHP/MariaDB host.
