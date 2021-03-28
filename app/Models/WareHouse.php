<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'warehouses';

    /**
    * Get the orders from this warehouse.
    *
    */
    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }
}
