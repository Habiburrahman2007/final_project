# Panduan Deployment ke cPanel

File GitHub Actions workflow (`main.yml`) telah dikonfigurasi untuk otomatis deploy project Laravel ke cPanel hosting setiap kali ada push ke branch `main`.

## Setup GitHub Secrets

Untuk menggunakan workflow ini, Anda perlu menambahkan 4 secrets di GitHub repository:

### Langkah-langkah Menambahkan Secrets:

1. Buka repository di GitHub
2. Klik **Settings** → **Secrets and variables** → **Actions**
3. Klik **New repository secret**
4. Tambahkan secrets berikut:

#### 1. FTP_SERVER
- **Name**: `FTP_SERVER`
- **Value**: Alamat FTP server Anda (contoh: `ftp.namadomainanda.com` atau IP address)

#### 2. FTP_USERNAME
- **Name**: `FTP_USERNAME`
- **Value**: Username FTP cPanel Anda

#### 3. FTP_PASSWORD
- **Name**: `FTP_PASSWORD`
- **Value**: Password FTP cPanel Anda

#### 4. FTP_SERVER_DIR
- **Name**: `FTP_SERVER_DIR`
- **Value**: Direktori tujuan upload di server (contoh: `/public_html/` atau `/`)

> **Catatan**: Pastikan path direktori diakhiri dengan `/` (slash)

## Informasi FTP cPanel

Untuk mendapatkan informasi FTP:

1. Login ke **cPanel**
2. Cari menu **FTP Accounts** atau **File Manager**
3. Informasi FTP Server biasanya: `ftp.namadomainanda.com` atau `namadomainanda.com`
4. Username dan password sama dengan yang Anda buat di FTP Accounts

## Cara Kerja Workflow

Setiap kali Anda push ke branch `main`, workflow akan:

1. ✅ Clone repository
2. ✅ Setup PHP 8.2
3. ✅ Install dependencies Composer (production only)
4. ✅ Setup Node.js
5. ✅ Install dependencies NPM
6. ✅ Build assets (CSS/JS) menggunakan Vite
7. ✅ Create direktori yang diperlukan
8. ✅ Set permissions yang benar
9. ✅ Upload semua file ke server via FTP

## File yang Tidak Di-upload

Workflow sudah dikonfigurasi untuk TIDAK mengupload file-file berikut:
- `.git` dan `.github`
- `node_modules`
- `tests`
- `.env` dan `.env.example`
- File konfigurasi development lainnya

## File yang DI-upload

File-file penting yang akan di-upload:
- ✅ Semua file aplikasi Laravel
- ✅ `vendor/` (dependencies Composer)
- ✅ `public/build/` (compiled assets)
- ✅ `bootstrap/`
- ✅ `storage/` (dengan struktur direktori yang benar)
- ✅ `database/migrations/`

## Setup di Server (Setelah Upload Pertama)

Setelah deployment pertama berhasil, Anda perlu melakukan setup berikut di server:

### 1. Buat File .env di Server

SSH ke server atau gunakan File Manager cPanel untuk create file `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database dan lainnya.

### 2. Setup Database

Di cPanel:
1. Buat database MySQL
2. Buat user database
3. Assign user ke database
4. Update `.env` dengan informasi database

### 3. Jalankan Migrations

```bash
php artisan migrate --force
```

### 4. Setup Storage Link

```bash
php artisan storage:link
```

### 5. Set Permissions (jika diperlukan)

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## Troubleshooting

### Error: "403 Forbidden" atau "404 Not Found"

- Pastikan file `.htaccess` ada di direktori `public/`
- Check apakah `public_html` mengarah ke folder `public/` di Laravel

### Error: "500 Internal Server Error"

1. Check file `.env` sudah dikonfigurasi dengan benar
2. Check permissions storage dan bootstrap/cache
3. Check PHP version di server (harus 8.2 atau lebih tinggi)
4. Enable error display di `.env`:
   ```
   APP_DEBUG=true
   ```

### Assets (CSS/JS) Tidak Muncul

- Pastikan `APP_URL` di `.env` sesuai dengan domain Anda
- Check `public/build/` folder sudah terupload

### Database Connection Error

- Verify kredensial database di `.env`
- Pastikan database sudah dibuat di cPanel
- Check database host (biasanya `localhost`)

## Testing Deployment

Untuk test deployment tanpa push ke main:

1. Buka tab **Actions** di GitHub repository
2. Select workflow **Deploy Laravel to cPanel**
3. Klik **Run workflow** → pilih branch `main`
4. Monitor progress dan check logs jika ada error

## Monitoring

- Check tab **Actions** di GitHub untuk melihat status deployment
- Setiap deployment akan memakan waktu sekitar 2-5 menit tergantung ukuran project dan kecepatan server

---

**Dibuat**: 4 Desember 2025
**Project**: Laravel Final Project
