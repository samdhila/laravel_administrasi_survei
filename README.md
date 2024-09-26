# Sistem Administrasi Survey

## Deskripsi
Sistem Administrasi Survey adalah platform yang dirancang untuk mengelola data survei secara efisien dan terstruktur. Sistem ini mencakup berbagai fitur yang memudahkan pengguna dalam merancang, mengumpulkan, dan menganalisis data survei.

## Fitur
- Menggunakan library **Role**
- Sistem ini mempunyai 2 role:
  - Admin
  - Surveyor
- Menggunakan library **Yajra Datatable**
- Color-coded Datatable

## Alur Sistem

- Pada **halaman Admin**, akan ditambahkan data baru yang perlu disurvei.
- **Admin** akan assign **surveyor** pada data yang telah ditambahkan
- Surveyor lalu akan melakukan survei pada data yang telah diberikan oleh Admin.
- Pada **halaman Surveyor**, surveyor bisa menandai suatu baris data **Done** apabila data yang diberikan sudah disurvei.
## Usage/Examples

```javascript
import Component from 'my-project'

function App() {
  return <Component />
}
```


## Cara Install Project

Install Composer
```bash
  https://getcomposer.org/
```

Clone Project Sistem Administrasi Survei.
```bash
  git clone https://github.com/samdhila/administrasi_survei/
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

Jalankan aplikasi web Laravel
```bash
  php artisan serve
```

Buka URL localhost pada web browser
```bash
  http://localhost:8000/
```
## Demo

Coming soon...

