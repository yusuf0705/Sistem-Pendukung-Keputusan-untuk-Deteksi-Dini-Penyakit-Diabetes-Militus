<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKesehatan extends Model
{
    protected $table = 'data_kesehatan_user';
    protected $primaryKey = 'id_data_kesehatan_user';

    protected $fillable = [
        'id_user',
        'nama',
        'usia',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'imt',
    ];
}
