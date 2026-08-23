# LacakKerja

LacakKerja adalah aplikasi Field Service Management untuk mengelola pelanggan, work order, dispatch teknisi, bukti pekerjaan, invoice, dan laporan operasional.

## Stack

- Laravel 13 + PHP 8.3+
- Livewire 4 + Flux UI
- Tailwind CSS 4 + Vite
- MySQL untuk production; SQLite dapat dipakai untuk local/test
- Database queue, session, dan cache agar kompatibel dengan cPanel

## Local setup

Jalankan dari folder `apps/`:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Sesuaikan `.env` bila memakai MySQL lokal. Untuk development, jalankan:

```powershell
composer run dev
```

Quality checks:

```powershell
php -d memory_limit=512M vendor/bin/phpstan analyse
php artisan test --compact
npm run build
```

## Struktur proyek

- `app/` — domain, Livewire, policies, actions, jobs, dan notifications.
- `resources/` — Blade views, CSS, dan JavaScript production.
- `database/` — migrations, factories, dan seeders.
- `template/` — visual reference dan screen plan.
- `../TASKS.md` — task board implementation.
- `../../PRD.md` — product requirements.

## Deployment target

Production diarahkan ke cPanel dengan document root ke `apps/public`, PHP 8.3+, MySQL, HTTPS, SMTP, cron scheduler, dan database queue worker strategy yang sesuai kemampuan hosting.