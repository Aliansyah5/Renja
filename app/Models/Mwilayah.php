<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mwilayah extends Model
{
    protected $table = 'mwilayah';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey =  'WilayahID';
    protected $guarded = [];


    public function ScopeAllWilayah($query)
    {
        $data = Mwilayah::get();
        return $data;
    }
}
