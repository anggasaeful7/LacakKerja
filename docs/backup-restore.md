# Backup dan restore LacakKerja

Runbook ini berlaku untuk deployment cPanel dengan MySQL dan private files di `storage/app/private`.

## Backup rutin

1. Aktifkan maintenance singkat bila backup dilakukan pada jam ramai.
2. Simpan `.env` di luar document root secara aman; jangan memasukkannya ke archive publik.
3. Export MySQL dengan transaksi konsisten:

```bash
mysqldump --single-transaction --routines --triggers --hex-blob \
  -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p "$DB_DATABASE" \
  > "backup-$(date +%Y%m%d-%H%M%S).sql"
```

4. Archive private files dan simpan di lokasi backup terenkripsi:

```bash
tar -czf "private-files-$(date +%Y%m%d-%H%M%S).tar.gz" storage/app/private
```

5. Catat timestamp, ukuran file, checksum (`sha256sum`), dan retention. Uji bahwa backup dapat dibaca sebelum menghapus salinan lama.

## Restore drill

Lakukan minimal sekali sebelum release dan gunakan database/staging terpisah.

1. Putuskan queue worker dan scheduler sementara.
2. Buat database kosong, import SQL, lalu extract `storage/app/private` dengan permission user aplikasi.
3. Salin `.env` staging tanpa secret ke log atau tiket.
4. Jalankan `php artisan migrate --force`, `php artisan optimize:clear`, lalu `php artisan optimize`.
5. Jalankan `php artisan test --compact` dan `php artisan route:list`.
6. Panggil `GET /health`; semua check harus `ok` dan respons tidak boleh berisi detail koneksi.
7. Verifikasi login, work order detail, download attachment private, invoice, dan queue worker.
8. Nyalakan kembali scheduler (`schedule:run` via cron setiap menit) dan worker queue.

## Kriteria berhasil

- Jumlah tabel dan record penting sesuai sumber backup.
- File private dapat di-download hanya melalui policy aplikasi.
- `/health` mengembalikan HTTP 200.
- Tidak ada secret, dump SQL, atau private file di `public/`.

Jika restore gagal, pertahankan database sumber dan rollback deployment ke artifact sebelumnya. Jangan menghapus backup terakhir sebelum smoke test selesai.