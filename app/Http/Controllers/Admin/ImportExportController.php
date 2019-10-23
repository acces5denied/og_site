<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exports\OffersExport;
use App\Imports\OffersImport;
use App\Exports\CatsExport;
use App\Imports\CatsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       $data = [
            'title' => 'Import/Export',
        ];
       return view('backend.importExport.import', $data);
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function exportOffers() 
    {
        return new OffersExport();
    }
    
    public function exportCats() 
    {
        return new CatsExport();
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importOffers() 
    {
        Excel::import(new OffersImport,request()->file('file'));
           
        return redirect()->route('importExportView')->with('status', 'Импорт завершен');
    }
    
    public function importCats() 
    {
        Excel::import(new CatsImport,request()->file('file'));
           
        return redirect()->route('importExportView')->with('status', 'Импорт завершен');
    }
}
