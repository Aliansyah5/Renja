<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mprovinsi extends Model
{
    protected $table = 'mprov';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey =  'ProvID';
    protected $guarded = [];

    public function ScopeAllProvinsi($query)
    {
        $data = Mprovinsi::get();
        return $data;
    }

}
