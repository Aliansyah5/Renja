<?php

namespace App\Http\Controllers;

use App\Models\DNotif;
use App\Models\MPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $validator = Validator::make(request()->all(), [
            'nik' => 'required|string|exists:qemployee,NIK',
            'page' => 'nullable|integer',
        ]);

        if ($validator->failed()) {
            return response()->json([
                'message' => 'Request not valid.',
                'meta' => $validator->errors(),
                'success' => false,
                'code' => 422
            ]);
        }

        $builder = DNotif::where('NIK', request('nik'))->where('IsDel', 0)->orderBy('CreatedDate', 'desc');

        if (request('page')) {
            $builder = $builder->limit(10)->offset((request('page') - 1) * 10)->get();
        } else {
            $builder = $builder->get();
        }

        return response()->json([
            'message' => 'Notification list.',
            'data' => $builder,
            'success' => true,
            'code' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|array',
            'target' => 'required',
            'title' => 'required',
            'content' => 'required',
            'private' => 'nullable|boolean',
            'send_email' => 'nullable|boolean',
        ]);

        if ($validator->failed()) {
            return response()->json([
                'message' => 'Request not valid.',
                'meta' => $validator->errors(),
                'success' => false,
                'code' => 422
            ]);
        }

        if (is_array($request->nik)) {
            foreach ($request->nik as $nik) {
                $email = null; 
                $name = null;
        
                if ($request->private) {
                    $employee = DB::table('qemployee')->where('NIK', $nik)->first();
                    $name = $employee->Name;
                    $email = $employee->EmailAddress;
                } else {
                    $mpegawai = MPegawai::where('Kode', $nik)->first();
                    $name = $mpegawai->Nama;
                    $email = $mpegawai->EmailKantor;
                }
        
                $dNotif = new DNotif();
                $dNotif->NotifID = (string) Str::uuid();
                $dNotif->NIK = $nik;
                $dNotif->Origin = $request->origin;
                $dNotif->Target = $request->target;
                $dNotif->Title = $request->title;
                $dNotif->HtmlContent = $request->content;
                $dNotif->RawContent = strip_tags(str_ireplace(["<br />","<br>","<br/>"], "\r\n", $request->content));
        
                if (!$request->has('send_email') || $request->send_email == true) {
                    $dNotif->Email = $email;
        
                    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        Mail::send([], [], function ($mail) use ($email, $name, $dNotif) {
                            $mail->to($email, $name)
                                ->subject($dNotif->Title)
                                ->setBody($dNotif->HtmlContent, 'text/html');
                        });
                    }
                }
        
                $dNotif->save();
            }
        }


        return response()->json([
            'message' => 'Notification has been sent.',
            'success' => true,
            'code' => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DNotif  $dNotif
     * @return \Illuminate\Http\Response
     */
    public function show(DNotif $dNotif)
    {
        $dNotif->IsRead = true;
        $dNotif->save();

        return response()->json([
            'message' => 'Notification shown.',
            'data' => $dNotif,
            'success' => true,
            'code' => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DNotif  $dNotif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DNotif $dNotif)
    {
        if ($request->has('is_read')) $dNotif->IsRead = $request->is_read;
        if ($request->has('target')) $dNotif->Target = $request->target;
        if ($request->has('origin')) $dNotif->Origin = $request->origin;
        if ($request->has('title')) $dNotif->Title = $request->title;
        if ($request->has('content')) {
            $dNotif->RawContent = $request->content;
            $dNotif->HtmlContent = $request->content;
        }
        $dNotif->save();

        return response()->json([
            'message' => 'Notification updated.',
            'data' => $dNotif,
            'success' => true,
            'code' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DNotif  $dNotif
     * @return \Illuminate\Http\Response
     */
    public function destroy(DNotif $dNotif)
    {
        $dNotif->IsDel = true;
        $dNotif->save();

        return response()->json([
            'message' => 'Notification has been deleted.',
            'success' => true,
            'code' => 200
        ]);
    }
}
