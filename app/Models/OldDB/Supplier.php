<?php

namespace App\Models\OldDB;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'mysql_second'; // Gunakan koneksi kedua
    protected $table = 'supplier';
}
