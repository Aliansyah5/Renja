<?php

namespace App\Http\Controllers;

use App\Models\Mprovinsi;
use App\Models\Mwilayah;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MasterProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('master.provinsi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['typeForm'] = "create";
        $data['Wilayah'] = Mwilayah::allWilayah();
        return view('master.provinsi.create', compact('data'));
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
        $wilid = Mprovinsi::max('ProvID') + 1;

        $data = [
            "ProvID" => $wilid,
            "Bagian" => $request->wilayah ?? '',
            "Provinsi" => $request->provinsi ?? '',
            'CreatedBy' => $user->UserID ?? 0,
            'CreatedDate' => Carbon::now(),
        ];

        $header = Mprovinsi::create($data);

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
        $currentObj = Mprovinsi::find($id);
        $data['Wilayah'] = Mwilayah::allWilayah();
        $data['dataModel'] = $currentObj;

        return view('master.provinsi.create', compact('data'));
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
        $currentObj = Mprovinsi::find($id);

        $data = [
            "Bagian" => $request->wilayah ?? '',
            "Provinsi" => $request->provinsi ?? '',
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
        $data = Mprovinsi::find($id)->delete();
        return new JsonResponse(["status" => true]);

    }

    public function getDatatable()
    {

        $list = Mprovinsi::select('mprov.ProvID','mwilayah.Bagian','mprov.Provinsi')
        ->leftJoin('mwilayah', 'mwilayah.WilayahID', '=', 'mprov.Bagian')
        ->get();

        return DataTables::of($list)
        ->addColumn('action', function ($data) {
            $url_edit = route('master.provinsi.edit',$data->ProvID);
            $url = route('master.provinsi.show',$data->ProvID);
            $url_delete = route('master.provinsi.destroy',$data->ProvID);
            $user = Auth::user();

            $edit = "";

                $edit = "<a class='btn-action btn btn-info btn-edit' href='".$url_edit."' title='Edit'><i class='fa fa-edit'></i></a>";

            $delete = "";
            $delete = "<button data-url='".$url_delete."' onclick='return deleteData(this)' class='btn-action btn btn-danger btn-delete' title='Delete'><i class='fa fa-trash'></i></button>";

            return $edit." ".$delete;

        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getProvinsi(Request $request)
    {
        $data = Mprovinsi::where('Bagian', $request->wilayahid)->get();
        return response()->json($data->toArray());
    }
}
