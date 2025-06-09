# CMS Sederhana dengan MVC

CMS (Content Management System) sederhana yang dibangun menggunakan pola MVC (Model-View-Controller).

## Fitur

- Manajemen Post (CRUD)
- Manajemen Kategori (CRUD)
- Editor WYSIWYG dengan TinyMCE
- Responsive design dengan Bootstrap 5

## Persyaratan

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache dengan mod_rewrite aktif
- XAMPP (direkomendasikan)

## Instalasi

1. Clone repository ini
2. Buat database baru di phpMyAdmin: `cms_sederhana_mvc`
3. Import file `database/cms_sederhana.sql`
4. Pastikan mod_rewrite Apache aktif
5. Akses melalui browser: `http://localhost/cms_sederhana`

## Struktur Folder

```
cms_sederhana/
├── app/
│   ├── config/     # Konfigurasi database
│   ├── controllers/# Controller
│   ├── core/       # Core framework
│   ├── models/     # Model
│   ├── views/      # View
│   └── bootstrap.php
├── public/         # File yang bisa diakses publik
└── database/       # File SQL
```

## Default Login

- Username: admin
- Password: admin123

## Teknologi yang Digunakan

- PHP
- MySQL
- Bootstrap 5
- TinyMCE
- jQuery

## Lisensi

MIT License 