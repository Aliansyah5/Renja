<?php

namespace App\Http\Controllers;

use App\Models\MTmpKartu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['datatable', 'show_bg']);
    }

    public function index()
    {
        $params['data'] = MTmpKartu::get();

        return view('master.template.index', $params);
    }

    public function datatables()
    {
        $collection = MTmpKartu::whereNotNull('Nama');

        return datatables()->of($collection)
            ->editColumn('BgDepan', function ($data) {
                return '<img src="'.route('master.template.show_bg', [$data->TmpID, 'depan']).'?timestamp='.Carbon::now()->unix().'" class="img-thumbnail" style="height: 10rem;" />';
            })
            ->editColumn('BgBelakang', function ($data) {
                return '<img src="'.route('master.template.show_bg', [$data->TmpID, 'belakang']).'?timestamp='.Carbon::now()->unix().'" class="img-thumbnail" style="height: 10rem;" />';
            })
            ->editColumn('IsFoto', function ($data) {
                return $data->IsFoto ? '<span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>' : '<span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>';
            })
            ->editColumn('IsNama', function ($data) {
                return $data->IsNama ? '<span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>' : '<span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>';
            })
            ->editColumn('IsNIK', function ($data) {
                return $data->IsNIK ? '<span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>' : '<span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>';
            })
            ->editColumn('IsRFID', function ($data) {
                return $data->IsRFID ? '<span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>' : '<span class="badge badge-danger"><i class="fas fa-times"></i> Tidak</span>';
            })
            ->editColumn('FontColor', function ($data) {
                return '<div style="background-color: #eee;text-align: center;"><i class="fas fa-square-full mr-2" style="color: '.$data->FontColor.'"></i>'.$data->FontColor.'</div>';
            })
            ->addColumn('opsi', function ($data) {
                return '<div class="btn-group">
                    <a href="'.route('master.template.edit', $data->TmpID).'" class="btn btn-sm btn-avian-secondary" title="Detail">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['opsi', 'IsFoto', 'IsNama', 'IsNIK', 'IsRFID', 'BgDepan', 'BgBelakang', 'FontColor'])
            ->make(true);
    }

    public function create()
    {
        return view('master.template.create');
    }

    public function store()
    {
        request()->validate([
            'nama' => 'required|unique:mtmpkartu,Nama',
            'bgdepan' => 'required|image|max:2048',
            'bgbelakang' => 'required|image|max:2048',
            'isfoto' => 'required|boolean',
            'isnama' => 'required|boolean',
            'isnik' => 'required|boolean',
            'isrfid' => 'required|boolean',
            'color' => 'required',
        ], [
            'bgdepan.image' => 'Background depan harus gambar.',
            'bgdepan.max' => 'Background depan maksimal :max KB.',
            'bgbelakang.image' => 'Background depan harus gambar.',
            'bgbelakang.max' => 'Background depan maksimal :max KB.',
        ]);

        $mtmpkartu = new MTmpKartu();
        $mtmpkartu->Nama = request()->nama;
        $mtmpkartu->IsFoto = request()->isfoto;
        $mtmpkartu->IsNama = request()->isnama;
        $mtmpkartu->IsNIK = request()->isnik;
        $mtmpkartu->IsRFID = request()->isrfid;
        $mtmpkartu->FontColor = request()->color;

        $folder = Str::slug(request()->nama, '_');

        if (request()->hasFile('bgdepan')) {
            $extension = request()->file('bgdepan')->extension();
            $mtmpkartu->BgDepan = request()->file('bgdepan')->storeAs('template/'.$folder, 'bgdepan.'.$extension);
        }
        
        if (request()->hasFile('bgbelakang')) {
            $extension = request()->file('bgbelakang')->extension();
            $mtmpkartu->BgBelakang = request()->file('bgbelakang')->storeAs('template/'.$folder, 'bgbelakang.'.$extension);
        }

        $mtmpkartu->save();

        return redirect()->route('master.template.index')->with('message', 'Template kartu berhasil disimpan.');
    }

    public function show_bg($id, $side)
    {
        $mtmpkartu = MTmpKartu::findOrFail($id);
        return response()->file(storage_path('app/'.$mtmpkartu->{'Bg'.Str::ucfirst($side)}));
    }

    public function edit($id)
    {
        $params['data'] = MTmpKartu::findOrFail($id);

        return view('master.template.edit', $params);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => 'required',
            'bgdepan' => 'image|max:2048',
            'bgbelakang' => 'image|max:2048',
            'isfoto' => 'required|boolean',
            'isnama' => 'required|boolean',
            'isnik' => 'required|boolean',
            'isrfid' => 'required|boolean',
            'color' => 'required',
        ], [
            'bgdepan.image' => 'Background depan harus gambar.',
            'bgdepan.max' => 'Background depan maksimal :max KB.',
            'bgbelakang.image' => 'Background depan harus gambar.',
            'bgbelakang.max' => 'Background depan maksimal :max KB.',
        ]);

        $mtmpkartu = MTmpKartu::findOrFail($id);
        $mtmpkartu->Nama = request()->nama;
        $mtmpkartu->IsFoto = request()->isfoto;
        $mtmpkartu->IsNama = request()->isnama;
        $mtmpkartu->IsNIK = request()->isnik;
        $mtmpkartu->IsRFID = request()->isrfid;
        $mtmpkartu->FontColor = request()->color;

        $folder = Str::slug(request()->nama, '_');

        if (request()->hasFile('bgdepan')) {
            $extension = request()->file('bgdepan')->extension();
            $mtmpkartu->BgDepan = request()->file('bgdepan')->storeAs('template/'.$folder, 'bgdepan.'.$extension);
        }
        
        if (request()->hasFile('bgbelakang')) {
            $extension = request()->file('bgbelakang')->extension();
            $mtmpkartu->BgBelakang = request()->file('bgbelakang')->storeAs('template/'.$folder, 'bgbelakang.'.$extension);
        }

        $mtmpkartu->save();

        return redirect()->route('master.template.index')->with('message', 'Template kartu berhasil disimpan.');
    }
}
