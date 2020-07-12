<?php

namespace App\Models;

class Employee extends User
{
    protected $table = 'users';
    protected $attributes = [
        'is_admin' => false,
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('is_admin', false);
        });
    }
}
