# Laravel Sistem Administrasi Survei

# Table of Contents

- [Laravel Sistem Administrasi Survei](#laravel-sistem-administrasi-survei)
  - [Deskripsi Sistem](#deskripsi-sistem)
  - [Detail Sistem](#detail-sistem)
  - [Alur Sistem](#alur-sistem)
  - [Live Demo](#live-demo)
  - [Setup Project](#setup-project)
    - [Pre-requirements](#pre-requirements)
    - [Local Installation](#local-installation)

## Deskripsi Sistem
**Sistem Administrasi Survei** adalah platform yang dirancang dengan menggunakan **Laravel 8** untuk mengelola data survei secara efisien dan terstruktur. Sistem ini mencakup berbagai fitur yang memudahkan pengguna dalam memanipulasi dan memantau data survei.

## Detail Sistem
- Menggunakan library **Spatie Permission** untuk integrasi sistem **Role**
- Sistem mempunyai 2 **Role**:
  - **Admin**
  - **Surveyor**
- Menggunakan library **Yajra Datatable** untuk mengelola tabel data
- **Color-coded** Datatable
- **Batch** manipulasi data menggunakan ***checkmark***

## Alur Sistem
- Login sebagai **Admin** atau **Surveyor**.
- Pada halaman **Admin**, bisa ditambahkan data baru yang perlu disurvei.
- **Admin** bisa menambah, mengedit, dan menghapus data survei.
- **Admin** bisa meng-assign **surveyor** pada data yang telah ditambahkan.
- **Surveyor** akan melakukan survei pada data yang telah diberikan oleh **Admin**.
- Pada **halaman Surveyor**, user bisa menandai suatu baris data sebagai **Done** apabila data yang diberikan oleh **Admin** sudah disurvei.
- **Admin** akan konfirmasi data yang sudah **Done**.

## Live Demo
Untuk demo percobaan aplikasi **Laravel Sistem Administrasi Survei**, bisa dilakukan pada
[URL Live Demo](https://survey.samreact.my.id/) ini.\

**Credential Admin (DEMO)**:\
admin@survey.com\
1234

**Credential Surveyor (DEMO)**:\
agus@survey.com\
password

![Demo Administrasi Survei Admin #01 GIF](https://github.com/samdhila/media/blob/main/laravel/lara01-optimized.gif)
![Demo Administrasi Survei Admin #02 GIF](https://github.com/samdhila/media/blob/main/laravel/lara02-optimized.gif)
![Demo Administrasi Survei User #01 GIF](https://github.com/samdhila/media/blob/main/laravel/lara03-optimized.gif)

## Setup Project

### Pre-requirements
**Xampp**
```bash
  https://www.apachefriends.org/download.html
```

**Composer**
```bash
  https://getcomposer.org/
```

### Local Installation
Clone project **Sistem Administrasi Survei**
```bash
  git clone https://github.com/samdhila/laravel_administrasi_survei.git
```

Buka CMD pada directory project
```bash
  cd laravel_administrasi_survei
```

Install composer
```bash
  composer install
```

Update composer
```bash
  composer update
```

Copy atau duplikat file **.env.example** ke file **.env** di dalam root folder.
```bash
  copy .env.example .env
```

Buka file **.env** lalu ubah nama database sesuai dengan yang ada di **PhpMyAdmin**.
```bash
  DB_DATABASE=laravel
```

Generate **App Key**
```bash
  php artisan key:generate
```

Migrasikan tabel pada database
```bash
  php artisan migrate
```

Migrasikan sample data untuk tabel database
```bash
  php artisan db:seed
```

Jalankan aplikasi web Laravel
```bash
  php artisan serve
```

Buka URL localhost pada web browser
```bash
  http://127.0.0.1:8000/
```

Login sebagai **Admin / Surveyor**
```bash
  http://127.0.0.1:8000/login
```
