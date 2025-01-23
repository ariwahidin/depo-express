<?php

namespace App\Models\OldDB;

use Illuminate\Database\Eloquent\Model;

class SizeTruck extends Model
{
    protected $connection = 'mysql_second'; // Gunakan koneksi kedua
    protected $table = 'size_truck';
}
