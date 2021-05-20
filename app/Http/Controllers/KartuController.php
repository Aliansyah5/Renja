<?php

namespace App\Http\Controllers;

use App\Models\DKartuPeg;
use App\Models\MTmpKartu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

class KartuController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $params['templates'] = MTmpKartu::get();

        return view('kartu', $params);
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
            ->addColumn('opsi', function ($data) {
                return '<div class="btn-group">
                    <button type="button" class="btn btn-sm btn-avian-secondary py-0 btn-profile" data-nik="'.$data->NIK.'" data-nama="'.$data->Name.'" title="Profil">
                        <i class="fas fa-id-card"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['opsi', 'Status'])
            ->make(true);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'nik' => 'required',
            'nama' => 'required',
            'rfid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Input not valid.',
            ], 500);
        }

        $rfid = ltrim(request()->rfid, '0');
        
        $kartu = DKartuPeg::where('RFID', $rfid)->first();
        if (!$kartu) {
            $kartu = new DKartuPeg();
            $kartu->RFID = $rfid;
        }

        $kartu->NIK = request()->nik;
        $kartu->Nama = request()->nama;
        $kartu->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully saved.',
        ], 200);
    }

    public function temp_foto()
    {
        return response()->file(storage_path('app/temporary/foto.jpg'));
    }

    public function print()
    {
        $validator = Validator::make(request()->all(), [
            'foto' => 'image|max:2048',
            'rfid' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'tmpid' => 'required',
            'side' => 'required|in:depan,belakang',
        ]);

        if ($validator->fails()) {
            return response('Input not valid!');
        }

        $template = MTmpKartu::findOrFail(request()->tmpid);

        $rfid = ltrim(request()->rfid, '0');

        if (request()->side == 'depan') {
            if (request()->hasFile('foto')) {
                request()->file('foto')->storeAs('temporary', 'foto.jpg');
                $params['foto'] = storage_path('app/temporary/foto.jpg'); // route('kartu.temp_foto');
            } else {
                $params['foto'] = null;
            }

            $params['rfid'] = $rfid;
            $params['nik'] = request()->nik;
            $params['nama'] = request()->nama;
        }
        
        $params['template'] = $template;
        $params['side'] = request()->side;
        $params['background'] = route('master.template.show_bg', [$template->TmpID, request()->side]); // storage_path('app/'.$template->BgDepan);

        // return view('print.kartu', $params);
        return PDF::loadView('print.kartu', $params)
            ->setOption('margin-top', 0)
            ->setOption('margin-left', 0)
            ->setOption('enable-local-file-access', true)
            ->inline($rfid.'.pdf');
    }
}
