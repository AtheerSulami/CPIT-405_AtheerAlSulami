# CPIT 405 — Lab 10: PHP & MariaDB

Student: **Atheer AlSulami** · **2307149**

Source assignment: https://cpit405.gitlab.io/labs/lab-10/

## Covered assessments

1. Power function with two parameters using a PHP loop (controllers/power.php).
2. UML diagram translated into Person and Professor classes, including inheritance (models/Person.php).
3. PDO database connection and the exact SQL query SHOW DATABASES; (models/DatabaseModel.php).

The homework is also demonstrated with PHP views, form-handling controllers, table-specific models, SQL creation/sample-data file, CRUD (create/read/update/delete), and a Fetch API (AJAX) example. All PHP files include the student's name and ID as comments.

## Required local setup

GitHub Pages cannot execute PHP or host MariaDB, so this project must run on a PHP server with MySQL/MariaDB installed (for example XAMPP, MAMP, or a system PHP + MariaDB installation).

1. Start MariaDB and import Documents/db-install-statements.sql (from inside Labs/Lab10, run: mysql -u root -p < Documents/db-install-statements.sql).
2. Set environment variables DB_HOST, DB_PORT, DB_USER, DB_PASSWORD and DB_NAME as needed. Defaults: 127.0.0.1, 3306, root, empty password, cpit405_lab10. Defaults are for local development only.
3. From the repository root, start: php -S 127.0.0.1:8000 -t Labs/Lab10
4. Browse to http://127.0.0.1:8000/

If your system does not have the mbstring PHP extension, enable it (used for task title length validation).

## Files

- index.php — entry point
- views/ — PHP page templates (no database queries)
- controllers/ — requests, validation, redirects and responses
- models/ — database connections, SQL, and UML OOP classes
- css/ — responsive styling
- js/ — AJAX Fetch API demo
- Documents/db-install-statements.sql — database schema and sample records
- Documents/project-sketch.pdf — class / database sketch
- Documents/project-description.pdf — project overview and instructions

## Security / implementation notes

Prepared PDO statements for task changes; form CSRF token; HTML escaping for database values; allowed status validation; post/redirect/get pattern; no stored secrets. The database-list endpoint displays schemas visible to the configured MariaDB user. Use a least-privileged database account in a deployed environment.
