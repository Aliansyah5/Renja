<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mkabupaten extends Model
{
    protected $table = 'mkab';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey =  'KabID';
    protected $guarded = [];

}
