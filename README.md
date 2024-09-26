# Laravel Sistem Administrasi Survei

## Deskripsi
**Sistem Administrasi Survei** adalah platform yang dirancang dengan menggunakan **Laravel 8** untuk mengelola data survei secara efisien dan terstruktur. Sistem ini mencakup berbagai fitur yang memudahkan pengguna dalam memanipulasi dan memantau data survei.

## Fitur
- Menggunakan library **Role**
- Mempunyai 2 role:
  - **Admin**
  - **Surveyor**
- Menggunakan library **Yajra Datatable**
- **Color-coded** Datatable
- **Batch** manipulasi data menggunakan ***checkmark***

## Alur Sistem

- Pada **halaman Admin**, akan ditambahkan data baru yang perlu disurvei.
- Admin bisa menambah, mengedit, dan menghapus data survei.
- **Admin** akan assign **surveyor** pada data yang telah ditambahkan.
- **Surveyor** lalu akan melakukan survei pada data yang telah diberikan oleh **Admin**.
- Pada **halaman Surveyor**, user bisa menandai suatu baris data **Done** apabila data yang diberikan oleh **Admin** sudah disurvei.
- **Admin** akan konfirmasi data yang sudah **Done**.
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

### Installation

Clone project **Sistem Administrasi Survei**
```bash
  git clone https://github.com/samdhila/laravel_administrasi_survei
```

Buka CMD pada directory project
```bash
  cd administrasi_survei
```

Install dependencies
```bash
  composer install
```

Update dependencies, bila diperlukan
```bash
  composer update
```

Copy **.env.example** ke **.env** di dalam root folder.
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
  http://localhost:8000/
```

Login sebagai **Admin / Surveyor**
```bash
  http://localhost:8000/
```

**Credential Admin (DEMO)**:\
admin@dataset.com\
password


**Credential Surveyor (DEMO)**:\
alpha@dataset.com\
password
## Demo

Coming soon...
