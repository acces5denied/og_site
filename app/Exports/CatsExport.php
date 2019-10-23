<?php

namespace App\Exports;

use App\Cat;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatsExport implements FromCollection, Responsable, WithHeadings
{
     use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName = 'export_cats.xlsx';
    
    public function collection()
    {
        return Cat::all();
    }
    
    public function headings(): array
    {
        return [
            'id',
            'name',
			'rating',
            'address',
            'geo_lat',
            'geo_lon',
            'text',
            'quote',
            'subway_id',
			'parking',
			'material_type',
			'is_complete',
			'quarter',
			'deadline_year',
			'slug',
            'seo_title',
            'seo_descr',
        ];
    }
}
