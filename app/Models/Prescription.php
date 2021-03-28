<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'prescriptions';

    /**
     * Get the customer that owns the prescription.
     */
    public function customer()
    {
        return $this->belongsTo(SpecialCustomer::class, 'special_customer_id');
    }

    /**
     * Get the prescriptions which contains this drug.
     */
    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'drug_prescription')->withPivot('packages_number', 'units_number', 'unit_sell_price', 'package_sell_price');
    }

    /**
     * Get the insurance company for the invoice.
     */
    public function insurance_company()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    /**
     * Get the payments for this invoice.
     */
    public function operations()
    {
        return $this->morphMany(AccountingOperation::class, 'operationable');
    }
}
