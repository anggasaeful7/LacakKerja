# Known limitations MVP

Dokumen ini menjadi batas aman sebelum fitur lanjutan dikerjakan.

- Browser push notification belum termasuk MVP; notifikasi email/in-app dan audit trail sudah tersedia.
- Offline sync masih memerlukan uji manual service-worker, quota storage, dan failed upload di HTTPS staging.
- PDF invoice belum dikunci ke library tertentu; print view HTML adalah jalur fallback cPanel.
- Health endpoint memeriksa koneksi database, private storage read/write, dan konfigurasi queue; monitoring worker eksternal tetap diperlukan.
- Upload MVP membatasi foto ke JPG/JPEG/PNG/WebP dan 10 MB; image thumbnail server-side belum menjadi pipeline terpisah.
- Scheduler mengirim reminder maksimal sekali per subject per hari berdasarkan audit log; perubahan timezone tenant perlu diuji di staging.
- Export laporan adalah CSV/streaming response; untuk dataset sangat besar tetap perlu batas tanggal dan monitoring timeout.
- Browser, screen-reader, keyboard-only, dan Lighthouse PWA pass final harus dilakukan pada staging HTTPS dengan data demo.