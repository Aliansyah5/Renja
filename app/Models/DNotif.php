<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DNotif extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';

    protected $table = 'dnotif';

    protected $primaryKey = 'NotifID';

    public $incrementing = false;

    public $keyType = 'string';

    protected $casts = [
        'IsRead' => 'boolean',
        'IsDel' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdateAt' => 'datetime',
    ];
}
