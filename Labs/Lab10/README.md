# CPIT 405 — Lab 10 Assessment Only

**Student:** Atheer AlSulami  
**Student ID:** 2307149  
**Source:** https://cpit405.gitlab.io/labs/lab-10/

This folder answers **only the three Lab Assessment questions**. No homework project or additional CRUD system is included.

| Question | File | Answer |
| --- | --- | --- |
| 1 | `power.php` | PHP function with two parameters, implemented iteratively, with a runnable form |
| 2 | `oop.php` | Convert the provided Person / Professor UML diagram to PHP classes and demonstrate inheritance |
| 3 | `databases.php` | Connect to MariaDB with PDO and retrieve database names using `SHOW DATABASES;` |

Run with **PHP 8.1+** from this directory:

```bash
php -S 127.0.0.1:8000
```

Then open http://127.0.0.1:8000/ to try all three questions.

Question 3 requires a running MariaDB/MySQL server and PHP's `pdo_mysql` extension. By default the connection uses `127.0.0.1:3306`, user `root`, and an empty password. You can change these with environment variables `DB_HOST`, `DB_PORT`, `DB_USER`, `DB_PASSWORD`. The database connection does **not** require creating any tables or importing SQL.

**Note:** GitHub Pages cannot execute PHP; the PHP assessment requires a PHP-enabled environment.
