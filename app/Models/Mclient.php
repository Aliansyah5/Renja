<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mclient extends Model
{
    protected $table = 'mclient';
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    protected $primaryKey =  'ClientID';
    protected $guarded = [];

    public function ScopeAllClient($query)
    {
        $data = Mclient::get();
        return $data;
    }

}
