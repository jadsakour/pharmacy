<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    /**
     * The corresponding table name.
     * @var string
     */
    protected $table = 'invoices';

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
        return $this->belongsToMany(Drug::class, 'drug_invoice')->withPivot('drug_package_number', 'drug_unit_number', 'modified_drug_unit_sell_price', 'modified_drug_package_sell_price');
    }

    /**
     * Get the invoices which contains this drug.
     */
    public function drug_repo()
    {
        return $this->belongsToMany(DrugsRepo::class, 'drug_invoice', 'id', 'drug_repo_id')->withPivot('drug_package_number', 'drug_unit_number');
    }

    /**
     * Get the payments for this invoice.
     */
    public function operations()
    {
        return $this->morphMany(AccountingOperation::class, 'operationable');
    }
}
