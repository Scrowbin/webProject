# InfinityFree deploy notes

## 403 on /library, /login, etc.

If you previously uploaded empty folders named `library`, `read`, `login`, `register`, `reading-history`, etc., **delete them in FTP**. Apache serves the folder, finds no `index.php`, and returns **403 Forbidden** before any `.htaccess` rewrite runs.

Keep only real content folders: `manga/`, `assets/`, `controllers/`, `uploads/`, …

## URLs (default)

Set in `.env`:

```
PRETTY_URLS=0
```

Links use `/controllers/...` and work without pretty URLs. Chapter example:

`/controllers/mangaRead_Controller.php?slug=ao-no-hako&chapter=2`

Set `PRETTY_URLS=1` only on local XAMPP or after you confirm root `.htaccess` works.

## Upload

- Root `.htaccess`
- `manga/.htaccess` (for `/manga/{id}/` images + slug pages)
- `.env` with `PRETTY_URLS=0`
