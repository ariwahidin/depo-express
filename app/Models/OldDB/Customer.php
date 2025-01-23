<?php

namespace App\Models\OldDB;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'mysql_second'; // Gunakan koneksi kedua
    protected $table = 'customer';
}
