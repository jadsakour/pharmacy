<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drugs';

    /**
     * Get the company that produces the drug.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the categort of the drug.
     */
    public function category()
    {
        return $this->belongsTo(DrugCategory::class, 'category_id');
    }

    /**
     * Get the prescriptions which contains this drug.
     */
    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'drug_prescription')->withPivot('packages_number', 'units_number', 'unit_sell_price', 'package_sell_price');
    }

    /**
     * Get the shape of the drug.
     */
    public function shape()
    {
        return $this->belongsTo(DrugShape::class, 'shape_id');
    }

    /**
     * Get the invoices which contains this drug.
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'drug_invoice')->withPivot('drug_package_number', 'drug_unit_number', 'modified_drug_unit_sell_price', 'modified_drug_package_sell_price');
    }

    /**
     * Get drug current quantity and dates.
     */
    public function repo()
    {
        return $this->hasMany(DrugsRepo::class, 'drug_id');
    }
}
