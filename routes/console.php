<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('avian:pwnt', function () {
    $pwnt = DB::connection('pwnt')
        ->table(DB::raw('[BADGE_CARD_SEARCH] bcs, [BADGE_CARD_ALL] bca'))
        ->whereRaw("bcs.[CARDNO] = bca.[CARDNO] and [COMPANY_NAM] <> 'LobbyWorks Visitors' and [COMPANY_NAM] not like 'PEMASOK'")
        ->selectRaw("bcs.[CARDNO] as [RFID], bca.[PINCODE] as [NIK], bcs.[FNAME] as [Nama]")
        ->get();

    $arr = [];
    foreach ($pwnt as $item) {
        if ($item->NIK) array_push($arr, (array)$item);
    }

    $result = DB::connection('avian')->table('dkartupeg')->upsert($arr, ['RFID'], ['RFID', 'NIK', 'Nama']);

    $this->info($result.' row affected.');
})->describe('Sync PWNT DB with Avian DB for access card data.');
