<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTmpKartu extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';

    protected $table = 'mtmpkartu';

    protected $primaryKey = 'TmpID';

    protected $connection = 'avian';

    protected $casts = [
        'IsFoto' => 'boolean',
        'IsNama' => 'boolean',
        'IsNIK' => 'boolean',
        'IsRFID' => 'boolean',
        'CreatedAt' => 'datetime',
        'UpdateAt' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->CreatedBy = auth()->user()->UserID ?? auth()->user()->id;
                $model->UpdateBy = auth()->user()->UserID ?? auth()->user()->id;
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->UpdateBy = auth()->user()->UserID ?? auth()->user()->id;
            }
        });
    }

    public function created_by()
    {
        return $this->belongsTo(MUser::class, 'CreatedBy', 'UserID');
    }
    
    public function update_by()
    {
        return $this->belongsTo(MUser::class, 'UpdateBy', 'UserID');
    }
}
