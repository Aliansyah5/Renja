<?php

namespace App\Http\Controllers;

use App\Models\DNotif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params['notifications'] = DNotif::where('NIK', auth()->user()->pegawai->Kode)->where('IsDel', 0)->orderBy('CreatedDate', 'desc')->get();

        return view('home', $params);
    }
    
    public function read_all()
    {
        DB::table('dnotif')->where('NIK', auth()->user()->pegawai->Kode)->update(['IsRead' => 1]);

        return redirect()->route('home');
    }

    public function show($id)
    {
        $notif = DNotif::findOrFail($id);
        $notif->IsRead = true;
        $notif->save();

        $url = request()->getSchemeAndHttpHost().$notif->Target;

        return redirect()->to($url);
    }

    public function read($id)
    {
        $notif = DNotif::findOrFail($id);
        $notif->IsRead = true;
        $notif->save();

        return redirect()->route('home');
    }
    
    public function delete($id)
    {
        $notif = DNotif::findOrFail($id);
        $notif->IsDel = true;
        $notif->save();

        return redirect()->route('home');
    }
}
