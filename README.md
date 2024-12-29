# Projek Jokian CRUD nih Boss!

## Persyaratan Sistem

-   PHP ≥ 8.2
-   Composer
-   Node.js & NPM
-   MySQL
-   PDO PHP Extension

## Cara Instalasi

### 1. Clone dulu repo-nya biar nggak ketinggalan zaman:

```bash
git clone https://github.com/zachran-recodex/crud-pabrik.git
cd crud-pabrik
```

### 2. Install semua kebutuhan kayak si tukang service:

```bash
composer install
npm install
```

### 3. Setel environment, biar nggak jalan di awan kosong:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Build project dulu ya bos:

```bash
npm run build
```

### 5. Edit database di .env kayak setting WiFi tetangga:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_pabrik
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrasi database biar nggak buta arah:

```bash
php artisan migrate
```

### 7. Gas server lokal kayak anak balap:

```bash
npm run dev
php artisan serve
```

### 8. Jangan lupa daftar akun dulu biar bisa login dan mulai eksplorasi fitur-fiturnya! Atau jalankan:

```bash
php artisan migrate:fresh --seed
```

Kemudian login untuk role Admin:
-   Email: admin@mail.com
-   Password: admin123

Login dengan untuk role User:
-   Email: user@mail.com
-   Password: user123

### 9. Kalo ga ada gambarnya ketik ini cuy:

```bash
php artisan storage:link
```

## Fitur

-   Login dan Registrasi yang nggak bikin pusing
-   CRUD buat ngatur data semudah ngatur playlist
-   Queue worker buat background tasks
-   Real-time logs pake Laravel Pail
-   Testing pake PEST

## Tools Development

-   Laravel Pint buat formatting code
-   Laravel Sail buat Docker environment
-   Vite buat asset bundling

## Catatan Penting

### 1. Hanya admin yang bisa ngatur CRUD Donasi

Kalau lu login pake akun admin, lu bisa tambah, edit, atau hapus data produk dan liat orderan. User biasa? Cuma bisa checkout doang, boss! Jadi nggak ada tuh cerita data acak-acakan sama user iseng.

### 2. Registrasi otomatis jadi user biasa

Pas daftar, lu langsung masuk ke role "User". Jadi kalo mau akses admin, harus ada yang ngasih lu role admin lewat database. Ini buat jaga-jaga aja biar nggak sembarangan jadi admin.

## Lisensi

Framework Laravel ini open-source, jadi bebas lu oprek! Lisensinya [MIT](https://opensource.org/licenses/MIT). Jangan lupa kopi, biar ngoding makin semangat!

## Pengembang
Kode ini dibikin sambil ngopi sama tim dari [Recodex ID](https://recodex.id). Kalau butuh bantuan, tinggal colek aja!
