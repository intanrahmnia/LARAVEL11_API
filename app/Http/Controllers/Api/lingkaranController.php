<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class LingkaranController extends Controller
{
    public function hitungLingkaran(Request $request)
    {
        $jariJari = $request->jari_jari;

        $luas = pi() * pow($jariJari, 2);
        $keliling = 2 * pi() * $jariJari;

        return new PostResource(true, 'Berhasil hitung lingkaran!', [
            'luas' => $luas,
            'keliling' => $keliling
        ]);
    }
}