<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Keuangan;
use App\Models\AppSetting;
use Carbon\Carbon;

class KasController extends Controller
{

    // KAS MASUK //
    public function showKasMasukPage(Request $request)
    {
        if($request->ajax()){
            $query = Keuangan::where('arus_kas', 'masuk');
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal_kas', function ($query) {
                    return $query->tanggal_kas ? with(new Carbon($query->tanggal_kas))->format('d-M-Y') : '';
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        } else {
            return view('kas.masuk');
        }
    }

    public function addDataKasMasuk(Request $request)
    {
       if($request->ajax()){
            $query = Keuangan::create([
                'keterangan'    => $request->keterangan,
                'masuk'         => $request->nominal,
                'keluar'        => NULL,
                'tanggal_kas'   => $request->tanggal_kas,
                'arus_kas'      => 'masuk',
                'created_by'     => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
       }
    }
    
    // KAS KELUAR //
    public function showKasKeluarPage(Request $request)
    {
        if($request->ajax()){
            $query = Keuangan::where('arus_kas', 'keluar');
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal_kas', function ($query) {
                    return $query->tanggal_kas ? with(new Carbon($query->tanggal_kas))->format('d-M-Y') : '';
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);  
        } else {
            return view('kas.keluar');
        }
    }

    public function addDataKasKeluar(Request $request)
    {
        if($request->ajax()){
            $query = Keuangan::create([
                'keterangan'    => $request->keterangan,
                'masuk'         => NULL,
                'keluar'        => $request->nominal,
                'tanggal_kas'   => $request->tanggal_kas,
                'arus_kas'      => 'keluar',
                'created_by'     => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    // Delete data
    public function deleteDataKas(Request $request)
    {
        if($request->ajax()){
            Keuangan::find($request->id)->delete($request->id);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    // Laporan
    public function showLaporanKas(Request $request)
    {
        return view('kas.laporan');
    }

    public function getLaporan(Request $request)
    {
        if($request){
            $from   = $request->from_date;
            $to     = $request->to_date;
            $query  = Keuangan::whereBetween('tanggal_kas', [$from, $to])->orderBy('tanggal_kas', 'asc')->get();

            // ambil tanggal tertua di database untuk saldo awal
            $oldest_date_first = Keuangan::orderBy('tanggal_kas', 'asc')->pluck('tanggal_kas')->first();
            $oldest_date_end = date('Y-m-d', strtotime('-1 days', strtotime($from)));
            $masuk_oldest  = Keuangan::whereBetween('tanggal_kas', [$oldest_date_first, $oldest_date_end])->where('arus_kas', 'masuk')->sum('masuk');
            $keluar_oldest  = Keuangan::whereBetween('tanggal_kas', [$oldest_date_first, $oldest_date_end])->where('arus_kas', 'keluar')->sum('keluar');
            $saldo_awal = $masuk_oldest - $keluar_oldest;

            $masuk_by_date  = Keuangan::whereBetween('tanggal_kas', [$from, $to])->where('arus_kas', 'masuk')->sum('masuk');
            $keluar_by_date = Keuangan::whereBetween('tanggal_kas', [$from, $to])->where('arus_kas', 'keluar')->sum('keluar');

            $data = [
                'ketua_bkm'     => AppSetting::where('id', '1')->first()->ketua_bkm,
                'bendahara_bkm' => AppSetting::where('id', '1')->first()->bendahara_bkm,
                'from_date'     => $from,
                'to_date'       => $to,
                'saldo_awal'    => $saldo_awal,
                'saldo_akhir'   => $saldo_awal + $masuk_by_date - $keluar_by_date, 
                'result'        => $query,
                'total_masuk'   => $masuk_by_date,
                'total_keluar'  => $keluar_by_date,
            ];
            return view('kas.print-laporan', $data);
        }
    }
}
