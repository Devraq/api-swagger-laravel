<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
	public $timestamps = false;
    protected $table = 'ms_mahasiswa';
    protected $fillable = [
        'mhs_nim', 'mhs_nama'
    ];
}
