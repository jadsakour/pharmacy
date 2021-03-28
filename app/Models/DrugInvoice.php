<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugInvoice extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drug_invoice';

    /**
     * Get the insurance company for the invoice.
     */
    public function insurance_company()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    /**
     * Get the invoice type for the invoice.
     */
    public function invoice_type()
    {
        return $this->belongsTo(InvoiceType::class);
    }

    /**
     * Get the invoices which contains this drug.
     */
    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'drug_invoice');
    }
}
