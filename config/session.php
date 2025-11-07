<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Driver "database" cocok untuk aplikasi multiuser agar data session
    | tersimpan di tabel. Kamu bisa ubah ke "file" jika belum membuat tabel
    | sessions dengan migrate.
    |
    | Supported: "file", "cookie", "database", "memcached", "redis", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Berapa menit session disimpan sebelum expired.
    | Jika ingin logout otomatis setelah 2 jam: 120 menit.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | Jika true, data session akan dienkripsi otomatis.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | Lokasi penyimpanan file session jika pakai driver "file".
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | Tentukan koneksi database (lihat config/database.php). Jika null,
    | maka pakai koneksi default.
    |
    */

    'connection' => env('SESSION_CONNECTION', null),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | Nama tabel untuk menyimpan session jika pakai driver "database".
    | Default-nya adalah "sessions".
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | Jika pakai "redis", "memcached", atau "dynamodb", tentukan store-nya.
    |
    */

    'store' => env('SESSION_STORE', null),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Peluang Laravel membersihkan session lama dari storage.
    | Format: [chance, out_of]
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Nama cookie session yang dikirim ke browser.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | Jalur (path) di mana cookie session berlaku.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Domain tempat cookie berlaku. Biarkan null untuk otomatis.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | Jika true, cookie hanya dikirim lewat HTTPS.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Jika true, JavaScript tidak bisa akses cookie session.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | Mengontrol perilaku cookie untuk permintaan lintas situs (CSRF).
    | Pilihan: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Aktifkan jika menggunakan fitur partitioned cookie (jarang diperlukan).
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
