<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hrenja extends Model
{
    protected $table = 'hrenja';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey =  'FormID';
    protected $guarded = [];

}
