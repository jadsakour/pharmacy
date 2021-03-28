<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugCategory extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drug_categories';

    /**
     * Get the drugs of this categories.
     */
    public function drugs()
    {
        return $this->hasMany(Drug::class, 'category_id');
    }
}
