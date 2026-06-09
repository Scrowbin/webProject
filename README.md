# Manga reading site

Done in PHP, with Bootstrap. Login and register not supported on infinityfree for now.

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

## Documentation

https://docs.google.com/document/d/1LQqUNJfQzXNXcTfmabsA-eMOgRs0G-RXjT15TzEdQGE/edit?usp=sharing

## Demo video

(Crude language)

https://drive.google.com/file/d/1J6XBd-2zaj7_VMWKA3QiTze55z42YPbg/view

## PHP configuration

Cần phải chỉnh trong php.ini các thứ sau, ko sẽ get bad response:

```
upload_max_filesize=40M
post_max_size = 50M
max_file_uploads=100
```
