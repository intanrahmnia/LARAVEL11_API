<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class SegitigaController extends Controller
{
    public function hitungSegitiga(Request $request)
    {
        $alas = $request->alas;
        $tinggi = $request->tinggi;
        $sisi1 = $request->sisi1;
        $sisi2 = $request->sisi2;
        $sisi3 = $request->sisi3;

        $luas = 0.5 * $alas * $tinggi;
        $keliling = $sisi1 + $sisi2 + $sisi3;

        return new PostResource(true, 'Berhasil hitung segitiga!', [
            'luas' => $luas,
            'keliling' => $keliling
        ]);
    }
}