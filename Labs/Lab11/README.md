# CPIT 405 — Lab 11 Assessment Only

**Student:** Atheer AlSulami  
**Student ID:** 2307149  
**Source:** https://cpit405.gitlab.io/labs/lab-11/

This folder answers **only the three Lab Assessment questions**. No homework project, database manager, XML exercise, or extra features are included.

1. **PHP keyed array:** `grades.php` creates `['Mohammad' => 4, 'Fahad' => 3.5]`.
2. **JSON:** The same PHP file returns JSON using `json_encode()`.
3. **AJAX and Console:** `script.js` calls the PHP file using `fetch()` and displays the parsed JSON with `console.log()`. Open `index.html` through the PHP server, open the browser's Developer Tools → Console, and click **Fetch JSON using AJAX**.

Run from this folder with PHP 8.1+:

```bash
php -S 127.0.0.1:8000
```

Open http://127.0.0.1:8000/index.html and test. No database is needed.

**Note:** GitHub Pages does not execute PHP, so the live JSON request needs a PHP-enabled server.
