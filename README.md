<p align="center">
  <img src="public/images/logo_nalarin_ai.png" alt="Nalarin.ai Logo" width="180">
</p>

# Nalarin.ai

Nalarin.ai adalah platform pembelajaran berbasis AI yang membantu pengguna mengubah materi belajar menjadi pengalaman belajar yang lebih aktif, terstruktur, dan interaktif. Aplikasi ini menggabungkan ringkasan materi, chat tutor, flashcards, kuis, pomodoro, serta fitur sosial seperti group chat kelas dan study matching.

## Visi Produk

Nalarin.ai dirancang untuk menjadi teman belajar digital yang tidak hanya membantu memahami materi, tetapi juga membantu pengguna menjaga ritme belajar, mengulang konsep penting, dan menemukan teman belajar baru.

## Fitur Utama

- Upload materi belajar berbasis teks atau file
- Ringkasan otomatis dari materi
- Chat tutor AI per materi
- Flashcards otomatis untuk review cepat
- Kuis pilihan ganda dari materi yang diunggah
- Pomodoro untuk manajemen fokus belajar
- Group chat kelas untuk belajar bersama
- Study matching untuk menemukan partner belajar
- Dashboard admin untuk pemantauan sistem

## Stack Teknologi

- Laravel 13
- PHP 8.3
- Blade
- Tailwind CSS
- Vite
- MySQL

## Struktur Inti

- `app/Http/Controllers`
  Logika utama aplikasi, termasuk fitur belajar, sosial, dan admin.
- `app/Models`
  Model domain seperti `Material`, `AiSummary`, `ChatThread`, `FlashcardDeck`, `QuizSet`, `StudyRoom`, dan `StudyMatch`.
- `app/Services/Learning`
  Service untuk generator konten belajar, ekstraksi teks materi, dan matching.
- `resources/views`
  Tampilan Blade untuk area publik, area user, dan area admin.
- `database/migrations`
  Definisi skema database.
- `database/seeders`
  Seeder untuk data demo dan pengujian.

## Cara Menjalankan Project

1. Install dependency:

```bash
composer install
npm install
```

2. Siapkan environment:

```bash
cp .env.example .env
php artisan key:generate
```

3. Atur koneksi database pada file `.env`, lalu jalankan:

```bash
php artisan migrate
php artisan db:seed
```

4. Jalankan aplikasi:

```bash
php artisan serve
npm run dev
```

## Akun Demo

Seeder demo menyiapkan beberapa akun untuk pengujian:

- `admin@nalarin.ai`
- `free@tester.com`
- `pro@tester.com`

Password default:

```text
password
```

## Catatan Pengembangan

- Fitur belajar utama sudah berjalan pada alur user login.
- Modul admin `users` dan `documents` sudah aktif.
- Halaman pomodoro masih memakai view mock yang memang dipakai langsung oleh route aktif.
- Beberapa bagian produk masih bersifat MVP dan bisa dikembangkan lebih lanjut, terutama pada integrasi AI real-time dan event activity admin.

## Tujuan Berikutnya

- Menyempurnakan integrasi model AI nyata
- Menambahkan event/activity feed admin berbasis data real
- Menambahkan realtime chat untuk room dan study matching
- Memperkuat audit, test coverage, dan readiness production

## License

Project ini dikembangkan untuk kebutuhan internal/pengembangan produk Nalarin.ai.
