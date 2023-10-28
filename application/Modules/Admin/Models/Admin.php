<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\CoreAuthenticatable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends CoreAuthenticatable
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $guarded = ['id'];
    protected $table = "admins";


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAttribute($key)
    {
        if ($key == 'last_login') {
            return jdate($this->attributes[$key])->ago();
        }
        return parent::getAttribute($key);
    }

    public function isRoleActive()
    {
        return $this->roles()->where('status', 'active')->exists();
    }

}
