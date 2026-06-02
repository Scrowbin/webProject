# Manga reading site

Done in PHP, with Bootstrap.

Deployed at: https://mangadax.infinityfree.io/


## Project structure

```
webProject/
├── assets/           # Site static files
│   ├── css/
│   ├── js/
│   └── static/       # Logo, icons, login background (UI only)
├── manga/            # Manga library: covers & chapter pages
│   └── {mangaId}/    #   e.g. 1/m1.jpg (cover), 1/2/1.jpg (chapter pages)
├── uploads/          # User profile images
│   ├── avatars/
│   └── banners/
├── controllers/      # Request handlers (routes point here via .htaccess)
├── models/           # Database access and business logic
├── views/            # Page templates and partials
│   └── includes/     # Navbar, sidebar, modals
├── utils/            # Shared helpers (e.g. mail)
├── database/         # SQL dumps and schema (manga1.sql)
├── scripts/          # One-off dev/maintenance scripts
├── _archive/         # Legacy prototypes (not used in production)
├── vendor/           # Composer dependencies (PHPMailer)
├── config/router.php # All pretty URLs (single front controller)
├── index.php         # Front controller → router or homepage
└── .htaccess         # Sends non-file requests to index.php
```

### URL routing

All pretty URLs (`/login`, `/read/{slug}/chapter-3`, `/library`, …) are handled by **one** `index.php` and `config/router.php`. You do not need `index.php` files inside route folders.

Root `.htaccess` sends any path that is not a real file or folder to `index.php?route=...`. The physical `manga/` folder (covers and pages) also has `manga/.htaccess` so slugs like `/manga/one-piece` reach the router when Apache looks inside that directory.

**InfinityFree:** upload the root `.htaccess` and `manga/.htaccess` only. All routes live in the root file; `manga/.htaccess` exists because cover/chapter images are stored in that folder. Do not add `.htaccess` under `library/`, `read/`, etc.

## Documentation

https://docs.google.com/document/d/1LQqUNJfQzXNXcTfmabsA-eMOgRs0G-RXjT15TzEdQGE/edit?usp=sharing

## Demo video

(Crude language)

https://drive.google.com/file/d/1J6XBd-2zaj7_VMWKA3QiTze55z42YPbg/view

## Environment (`.env`)

Copy `.env.example` to `.env` and set your database credentials:

```
DB_HOST=sql203.infinityfree.com
DB_USER=if0_42068234
DB_PASS=your-password
DB_NAME=if0_42068234_manga
```

All PHP entry points load `config/bootstrap.php`, which reads `.env`. Includes use `__DIR__` (not `$_SERVER['DOCUMENT_ROOT']`) so paths work on InfinityFree and local XAMPP.

Upload `.env` via FTP but **never commit it to Git** (it is in `.gitignore`).

## Import database (`database/manga1.sql`)

**InfinityFree (phpMyAdmin):**

1. Log in to InfinityFree → MySQL Databases → **phpMyAdmin**.
2. In the **left sidebar**, click **`if0_42068234_manga`** (your database name).
3. Click the **Import** tab at the top.
4. Choose `manga1.sql` and run import.

Do **not** import from the home SQL tab without selecting the database first — that causes `#1046 - No database selected`.

**Local XAMPP:** Create a database named `manga`, select it in the left sidebar, then Import the same file.

## PHP configuration

Cần phải chỉnh trong php.ini các thứ sau, ko sẽ get bad response:

```
upload_max_filesize=40M
post_max_size = 50M
max_file_uploads=100
```
