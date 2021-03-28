<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugPrescription extends Model
{
    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drug_prescription';

    /**
     * Get the prescription.
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Get the drug.
     */
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
