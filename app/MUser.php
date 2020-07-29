<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MUser extends Authenticatable
{
    use Notifiable;

    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'UpdateDate';
    
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
}
