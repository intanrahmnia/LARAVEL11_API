<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PersegiController extends Controller
{
    public function hitungPersegi(Request $request)
    {
        $sisi = $request->sisi;
        $hitung = $sisi * $sisi;

        return new PostResource(true, 'Berhasil hitung luas persegi!', [
            'hasil' => $hitung
        ]);
    }
    
}