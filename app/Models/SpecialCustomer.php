<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialCustomer extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'special_customers';

    /**
     * Get the prescriptions for the customer.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
