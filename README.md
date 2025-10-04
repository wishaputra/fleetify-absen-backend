Fleetify Absen – Backend (API Documentation)
Ringkas

Aplikasi ini adalah Backend API berbasis Laravel 11 + MySQL untuk sistem absensi karyawan.
Fitur utama:

CRUD Departemen

CRUD Karyawan

Absensi Masuk & Keluar

Laporan Log Absensi dengan filter tanggal & departemen

Prasyarat

PHP ≥ 8.1

Composer

MySQL

Node.js (untuk vite dev di frontend, opsional di backend)

Menjalankan Backend
# clone repo
git clone https://github.com/<username>/fleetify-absen-backend.git
cd fleetify-absen-backend

# install dependencies
composer install

# konfigurasi .env
cp .env.example .env
php artisan key:generate

# set database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fleetify_absen
DB_USERNAME=root
DB_PASSWORD=

# migrasi & seed
php artisan migrate --seed

# jalankan server dev
php artisan serve
# API jalan di http://127.0.0.1:8000/api

Endpoint Utama
1. Departments

GET /api/departments → daftar departemen (paginate)

POST /api/departments → buat departemen baru

GET /api/departments/{id} → detail departemen

PUT /api/departments/{id} → update departemen

DELETE /api/departments/{id} → hapus departemen

Contoh payload POST/PUT:

{
  "name": "Engineering",
  "code": "ENG",
  "max_checkin_time": "09:00",
  "max_checkout_time": "17:00"
}

2. Employees

GET /api/employees → daftar karyawan

POST /api/employees → buat karyawan

GET /api/employees/{id} → detail karyawan

PUT /api/employees/{id} → update karyawan

DELETE /api/employees/{id} → hapus karyawan

Contoh payload POST/PUT:

{
  "employee_code": "EMP001",
  "name": "Alice",
  "email": "alice@example.com",
  "department_id": 1
}

3. Attendance
a) Check-In

POST /api/attendance/check-in

Payload:

{
  "employee_id": 1,
  "timestamp": "2025-10-05T08:55:00",
  "work_date": "2025-10-05"
}


Respons menandakan status_in → on_time atau late.

b) Check-Out

PUT /api/attendance/check-out

Payload:

{
  "employee_id": 1,
  "timestamp": "2025-10-05T17:05:00",
  "work_date": "2025-10-05"
}


Respons menandakan status_out → on_time atau early_leave.

c) Logs

GET /api/attendance/logs

Query params:

department_id (opsional)

employee_id (opsional)

date_from (opsional, YYYY-MM-DD)

date_to (opsional, YYYY-MM-DD)

Contoh:

/api/attendance/logs?department_id=1&date_from=2025-10-01&date_to=2025-10-31


Respons: daftar absensi + relasi karyawan & departemen.

Data Model Singkat

departments

id, name, code, max_checkin_time, max_checkout_time

employees

id, employee_code, name, email, department_id

attendances

id, employee_id, work_date, check_in_at, status_in, late_minutes, check_out_at, status_out, early_leave_minutes

Validasi

Department: name, code unik; jam masuk/keluar format H:i.

Employee: email & employee_code unik; harus terkait departemen.

Attendance: employee_id valid; otomatis deteksi status on-time/late/early-leave.

Troubleshooting Cepat

Seeder gagal → pastikan DatabaseSeeder.php memanggil $this->call([DepartmentSeeder::class, EmployeeSeeder::class]);.

404 di Postman → cek routes/api.php dan pastikan bootstrap/app.php register api.php.

CORS error → update config/cors.php agar origin frontend diizinkan.

Data kosong di Logs → cek parameter date_from & date_to, dan pastikan ada absensi untuk tanggal itu.
