<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * Get the warehouse or company related to this order.
     */
    public function orderable()
    {
        return $this->morphTo();
    }

    /**
     * Get the drugs of this order (from drug_order_send table)
     */
    public function drugs_send()
    {
        return $this->hasMany(DrugOrderSend::class, 'order_id');
    }

    /**
     * Get the drugs of this order (from drug_order_Receive table)
     */
    public function drugs_receive()
    {
        return $this->hasMany(DrugOrderReceive::class, 'order_id');
    }

    /**
     * Get the payments for this order.
     */
    public function operations()
    {
        return $this->morphMany(AccountingOperation::class, 'operationable');
    }
}
