<?php

namespace App\Http\Controllers;

use App\Models\DKartuPeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.karyawan.index');
    }

    public function datatables()
    {
        $collection = DB::connection('avian')
            ->table('qemployee')
            ->whereIn('CompanyArea', [10000, 11000, 12000, 13000, 14000])
            ->select('NIK', 'Name', 'Status', DB::raw('NULL as `Kartu`'));

        return datatables()->of($collection)
            ->editColumn('Status', function ($data) {
                return $data->Status == 'ACTIVE' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Non-Aktif</span>';
            })
            ->editColumn('Kartu', function ($data) {
                $no_kartu = DKartuPeg::where('NIK', $data->NIK)->pluck('RFID')->toArray();
                return implode(', ', $no_kartu);
            })
            ->rawColumns(['opsi', 'Status'])
            ->make(true);
    }
    
    public function kartu_index()
    {
        return view('master.kartu.index');
    }

    public function kartu_datatables()
    {
        $collection = DKartuPeg::whereNotNull('RFID');

        if (request()->has('rfid') && request()->rfid != '') {
            $collection = $collection->where('RFID', ltrim(request()->rfid, '0'));
        }

        return datatables()->of($collection)->make(true);
    }
}
