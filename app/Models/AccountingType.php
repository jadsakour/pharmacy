<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingType extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'accounting_types';

    /**
     * Get the operations for the type.
     */
    public function operations()
    {
        return $this->hasMany(AccountingOperation::class);
    }
}
