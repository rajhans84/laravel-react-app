<?php

namespace App\Models;

class Admin extends User
{
    protected $table = 'users';
    protected $attributes = [
        'is_admin' => true,
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('is_admin', true);
        });
    }
}
