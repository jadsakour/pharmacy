<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugShape extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drug_shapes';

    /**
     * Get the drugs that have this shape.
     */
    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }
}
