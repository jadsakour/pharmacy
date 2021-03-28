<?php

use bfinlay\SpreadsheetSeeder\SpreadsheetSeeder;
use Illuminate\Support\Facades\DB;

class FilesSeeder extends SpreadsheetSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // By default, the seeder will process all XLSX files in /database/seeds/*.xlsx (relative to Laravel project base path)
        $this->worksheetTableMapping = ['companies' => 'companies', 'drug_shapes' => 'drug_shapes', 'drugs_1' => 'drugs', 'drugs_2' => 'drugs'];

        $this->truncate = false;

        parent::run();
    }
}
