<?php

namespace App\Exports;

use App\Models\Rapot; //File Model
use App\Models\Siswa; //File Model
use Maatwebsite\Excel\Concerns\FromCollection;

class RapotExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        // return ExportRaport::all();
        return ExportRapot::all();
    }
}
