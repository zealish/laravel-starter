# 🚀 Zealish Laravel Starter 2026

Starter template Laravel 11/12 yang dioptimalkan untuk performa tinggi, SEO dinamis, dan kemudahan manajemen pada Shared Hosting.

## ✨ Fitur Utama

### 1. **Modern Frontend Stack**

- **Tailwind CSS 4**: Menggunakan versi terbaru untuk build yang lebih cepat dan ukuran CSS minimal.
- **Livewire 3**: Interaktivitas tinggi tanpa meninggalkan kenyamanan Blade.

### 2. **Ultimate SEO System**

- **Dynamic Settings**: Integrasi `spatie/laravel-settings` dengan `artesaos/seotools`.
- **Smart Fallback**: Metadata (Title, Description, Image) otomatis mengambil dari _General Settings_ jika konten artikel kosong.
- **JSON-LD Schema**: Skema otomatis untuk `WebPage`, `BlogPosting`, dan `Breadcrumbs`.
- **Tracking Ready**: Kolom input Google Analytics/GTM yang bisa diatur langsung dari Dashboard.

### 3. **Asset Optimization**

- **Auto-WebP**: Konversi otomatis semua unggahan gambar ke format `.webp`.
- **Smart Resize**: Otomatis mengubah ukuran gambar ke lebar maksimal 1200px untuk menghemat penyimpanan.
- **Lazy Loading**: Terintegrasi secara bawaan pada komponen gambar.

### 4. **Professional Admin Dashboard (Filament)**

- **Command Palette (Ctrl+K)**: Navigasi instan ke Artikel, Kategori, atau Tag.
- **System Widgets**: Monitoring penggunaan storage dan status artikel (Draft vs Published).
- **Maintenance Tools**: Tombol "Clear Cache" sekali klik untuk optimasi server tanpa SSH.

## 🛠 Instalasi

1. **Clone Repository**
   git clone [https://github.com/username/laravel-starter.git](https://github.com/username/laravel-starter.git)
   cd laravel-starter
   Bash

2. **Install Dependencies**
   Install Dependencies
   Bash

3. **Composer Install**
   composer install
   npm install && npm run build

    Environment Setup
    Bash

    cp .env.example .env
    php artisan key:generate

    Database & Settings
    Bash

    php artisan migrate
    php artisan settings:clear-cache

    Storage Link
    Bash

    php artisan storage:link

📂 Struktur Penting

    app/Traits/HasSeo.php: Pusat kendali logika SEO aplikasi.

    app/Settings/GeneralSettings.php: Definisi variabel pengaturan global.

    app/Core/FileFactory.php: Helper pengolah gambar (Resize & WebP).

    app/Filament/Widgets/: Custom dashboard widgets (Clear Cache & Stats).

🚀 Tips Deployment (Shared Hosting)

    Pastikan versi PHP minimal 8.2.

    Jika tidak memiliki akses SSH, gunakan route sementara untuk menjalankan Artisan::call('storage:link').

    Jalankan php artisan optimize setiap kali melakukan perubahan pada file konfigurasi di produksi.

Built with ❤️ by Zealish Team
