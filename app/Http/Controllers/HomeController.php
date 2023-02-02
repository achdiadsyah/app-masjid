<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;

class HomeController extends Controller
{
    public function showHomePage(Request $request)
    {
        if($request->ajax()){
            $masuk = Keuangan::where('arus_kas', 'masuk')->sum('masuk');
            $keluar = Keuangan::where('arus_kas', 'keluar')->sum('keluar');
            $data = [
                'kas_masuk'     => (int)$masuk,
                'kas_keluar'    => (int)$keluar,
                'sisa_saldo'    => $masuk - $keluar, 
            ];
            return response()->json($data, 200);
        }
        return view('home');
    }
}
