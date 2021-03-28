<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugOrderSend extends Model
{
    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drug_order_send';

    /**
     * Get the drug related to this order.
     */
    public function drug()
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }

    /**
     * Get the order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
