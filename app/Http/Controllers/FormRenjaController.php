<?php

namespace App\Http\Controllers;

use App\Models\Hrenja;
use App\Models\Mkabupaten;
use App\Models\Mprovinsi;
use App\Models\Mwilayah;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FormRenjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('form.renja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['typeForm'] = "create";
        $data['Provinsi'] = Mprovinsi::allProvinsi();
        $data['Wilayah'] = Mwilayah::allWilayah();
        return view('form.renja.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        foreach($request->kode as $key => $value){

            $wilid = Hrenja::max('FormID') + 1;

            $data = [
                "FormID" => $wilid,
                "NoForm" => $request->kode[$key] ?? '',
                "Pembina" => $request->pic[$key] ?? '',
                "Aktifitas" => $request->aktifitas[$key] ?? '',
                "Kegiatan" => $request->kegiatan[$key] ?? '',
                "User" => $request->user[$key] ,
                "Wilayah" => $request->wilayah[$key],
                "Provinsi" => $request->provinsi[$key] ,
                "Kabupaten" => $request->kabupaten[$key] ,
                "SubCabang" => $request->subcabang[$key] ,
                'CreatedBy' => $user->UserID ?? 0,
                'CreatedDate' => Carbon::now()
            ];


            $header = Hrenja::create($data);
        }

        return response()->json([
            'Code'             => 200,
            'Message'          => "Success Add"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['typeForm'] = "edit";
        $currentObj = Mkabupaten::find($id);
        $data['Provinsi'] = Mprovinsi::allProvinsi();
        $data['dataModel'] = $currentObj;

        return view('master.kabupaten.create', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $currentObj = Mkabupaten::find($id);

        $data = [
            "Provinsi" => $request->provinsi ?? '',
            "Kabupaten" => $request->kabupaten ?? '',
            'UpdateBy' => $user->UserID ?? 0,
            'UpdateDate' => Carbon::now()
        ];

        $currentObj->update($data);
        $currentObj->save();

        return response()->json([
            'Code'             => 200,
            'Message'          => "Success Edit"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Hrenja::find($id)->delete();
        return new JsonResponse(["status" => true]);

    }

    public function getDatatable()
    {

        $list =
        Hrenja::select('hrenja.*', 'mwilayah.Bagian', 'mprov.Provinsi', 'mkab.Kabupaten')
        ->leftJoin('mwilayah', 'hrenja.Wilayah', '=', 'mwilayah.WilayahID')
        ->leftJoin('mprov', 'hrenja.Provinsi', '=', 'mprov.provID')
        ->leftJoin('mkab', 'hrenja.Kabupaten', '=', 'mkab.kabID')
        ->get();

        return DataTables::of($list)
        ->addColumn('action', function ($data) {
            $url_edit = route('form.renja.edit',$data->FormID);
            $url = route('form.renja.show',$data->FormID);
            $url_delete = route('form.renja.destroy',$data->FormID);
            $user = Auth::user();

            $edit = "";

                $edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";

            $delete = "";
            $delete = "<button data-url='".$url_delete."' onclick='return deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash'></i></button>";

            //return $edit." ".$delete;
            return $delete;

        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getNoForm(Request $request)
    {
        $user = Auth::user()->Username ;

        $bulan = date('m');
        $tahun = date('y');

        $form = $request->pic.'-'.$request->kodeaktifitas.'-'.$request->user.'-'.substr($request->cabanguser, 0, 3)
        .'-'.$tahun.$bulan.'-';

        $fixform = strval($form);

        $iteration = Hrenja::whereraw("NoForm like '%$fixform%'")
            ->max(DB::raw('substring(NoForm, 21, 4)')) + 1;

        if ($iteration <= 9) {
            $kode = $fixform.'00'.($iteration);
        } else if ($iteration <= 99) {
            $kode =  $fixform.'0'.($iteration);
        } else if ($iteration <= 999) {
            $kode =  $fixform.'0'.($iteration);
        } else {
            $kode =  $fixform.($iteration);
        }

        return response()->json($kode);
    }
}
