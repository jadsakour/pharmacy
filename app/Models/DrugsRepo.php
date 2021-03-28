<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugsRepo extends Model
{

    /**
     * The corresponding table name.
     *
     * @var string
     */
    protected $table = 'drugs_repo';

    /**
     * Get the drug which this repo belongs to.
     */
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
    
}
