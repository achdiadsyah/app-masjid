<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPengajian;
use App\Models\AppSetting;
use DataTables;
use Carbon\Carbon;

class PengajianController extends Controller
{
    public function showPengajianShubuhPage(Request $request)
    {
        if($request->ajax()){
            $query = JadwalPengajian::where('pengajian', 'shubuh');
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($query) {
                    return $query->tanggal ? with(new Carbon($query->tanggal))->format('d-M-Y') : '';
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        } else {
            return view('pengajian.shubuh');
        }
    }

    public function showPengajianMagribPage(Request $request)
    {
        if($request->ajax()){
            $query = JadwalPengajian::where('pengajian', 'magrib');
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($query) {
                    return $query->tanggal ? with(new Carbon($query->tanggal))->format('d-M-Y') : '';
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        } else {
            return view('pengajian.magrib');
        }
    }
    
    public function showPengajianWanitaPage(Request $request)
    {
        if($request->ajax()){
            $query = JadwalPengajian::where('pengajian', 'wanita');
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($query) {
                    return $query->tanggal ? with(new Carbon($query->tanggal))->format('d-M-Y') : '';
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        } else {
            return view('pengajian.wanita');
        }
    }

    public function addPengajian(Request $request)
    {
        if($request->ajax()){
            $query = JadwalPengajian::create([
                'pengajian'                     => $request->pengajian,
                'tanggal'                       => $request->tanggal,
                'waktu'                         => $request->waktu,
                'pengisi_kajian'                => $request->pengisi_kajian,
                'keterangan_pengisi_kajian'     => $request->keterangan_pengisi_kajian,
                'topik_kajian'                  => $request->topik_kajian,
                'created_by'                    => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    public function deletePengajian(Request $request)
    {
        if($request->ajax()){
            JadwalPengajian::find($request->id)->delete($request->id);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }
}
