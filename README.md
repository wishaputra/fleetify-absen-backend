🚀 Fleetify Absen Backend

Halo! 👋 Ini adalah backend untuk aplikasi Fleetify Absen. Dibikin pakai Laravel + MySQL.

Backend ini bersangkutan:

- data departemen,
- data karyawan,
- catat absen masuk & keluar,

sama laporan absensi (lengkap sama status telat atau pulang cepat).

⚙️ Cara Setup Backend

Clone repo dulu

git clone https://github.com/wishaputra/fleetify-absen-backend.git
cd fleetify-absen-backend


Install package

composer install


Bikin file .env

cp .env.example .env
php artisan key:generate


Terus edit bagian DB biar nyambung ke MySQL kamu:

DB_DATABASE=fleetify_absen
DB_USERNAME=root
DB_PASSWORD=


Migrasi + seeder (biar ada data awal)

php artisan migrate --seed


Jalankan server

php artisan serve --port=8000


✅ Backend siap diakses di http://127.0.0.1:8000