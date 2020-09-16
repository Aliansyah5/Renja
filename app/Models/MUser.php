<?php

namespace App\Models;

use App\Traits\AviaPermit;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MUser extends Authenticatable
{
    use Notifiable, AviaPermit;
    
    protected $table = 'muser';

    protected $primaryKey = 'UserID';

    public $timestamps = false;

    protected $hidden = ['Passwd'];

    protected $casts = [
        'IsDel' => 'bool',
        'CreatedAt' => 'datetime',
        'UpdateAt' => 'datetime',
    ];

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
            parent::setAttribute($key, $value);
    }

    public function permits()
    {
        return $this->belongsToMany('App\MMenu', 'mpermit', 'UserID', 'MenuID')->withPivot('Permit');
    }

    public function pegawai()
    {
        return $this->hasOne('App\MPegawai', 'PegawaiID', 'PegawaiID');
    }

    public function approval1()
    {
        return $this->hasMany('App\HPatrol', 'UserID', 'AppBy1');
    }
    
    public function approval2()
    {
        return $this->hasMany('App\HPatrol', 'UserID', 'AppBy2');
    }
    
    public function approval3()
    {
        return $this->hasMany('App\HPatrol', 'UserID', 'AppBy3');
    }
    
    public function approval4()
    {
        return $this->hasMany('App\HPatrol', 'UserID', 'AppBy4');
    }
}
