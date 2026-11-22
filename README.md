# Courier API

REST API Laravel untuk CRUD master data kurir. Project tidak memuat UI.

## Data Kurir

- `name`: nama kurir
- `email`: email unik dan opsional
- `phone`: nomor telepon unik dan opsional
- `level`: integer 1 sampai 5
- `vehicle_type`: jenis kendaraan
- `is_active`: status aktif
- `registered_at`: tanggal pendaftaran

## Instalasi

```bash
composer install
php artisan migrate
php artisan serve
```

## Endpoint

| Method | Endpoint | Deskripsi |
|---|---|---|
| GET | `/api/couriers` | Daftar kurir dengan pagination |
| GET | `/api/couriers/{courier}` | Detail satu kurir |
| POST | `/api/couriers` | Membuat kurir |
| PUT/PATCH | `/api/couriers/{courier}` | Memperbarui kurir |
| DELETE | `/api/couriers/{courier}` | Menghapus kurir |

## Opsi Filter dan Sorting

- Default sorting: `?sort=name&direction=asc`
- Sorting tanggal: `?sort=registered_at&direction=desc`
- Pencarian nama: `?search=budi+agung`
- Filter level: `?level=2,3`
- Ukuran pagination: `?per_page=20`

## Pengujian

```bash
php artisan test
```
