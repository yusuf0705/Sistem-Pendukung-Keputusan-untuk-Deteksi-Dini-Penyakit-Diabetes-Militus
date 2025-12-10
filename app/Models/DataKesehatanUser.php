<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatanUser extends Model
{
    use HasFactory;

    protected $table = 'data_kesehatan_user';   // nama tabel
    protected $primaryKey = 'id_data_kesehatan_user'; // primary key

    public $incrementing = true; // PK auto increment
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nama',
        'usia',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'imt',
    ];

    /**
     * Relasi ke tabel users
     * 1 data kesehatan dimiliki oleh 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
