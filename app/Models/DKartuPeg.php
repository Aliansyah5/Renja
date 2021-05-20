<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DKartuPeg extends Model
{
    use HasFactory;

    protected $table = 'dkartupeg';

    protected $primaryKey = 'RFID';

    protected $connection = 'avian';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['NIK', 'RFID', 'Nama'];
}
