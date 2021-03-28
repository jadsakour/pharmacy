<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * Get the drugs for the company.
     */
    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

    /**
     * Get the orders from this company.
     *
     */
    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }
}
