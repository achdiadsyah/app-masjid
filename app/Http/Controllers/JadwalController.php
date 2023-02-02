<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\JadwalSholatUmum;
use App\Models\JadwalSholatKhusus;
use App\Models\AppSetting;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function showSholatUmumPage(Request $request)
    {
        if($request->ajax()){
            $query = JadwalSholatUmum::orderBy('tanggal', 'desc')->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($query) {
                    return $query->tanggal ? longdate_indo($query->tanggal) : '';
                })
                ->editColumn('sholat', function ($query) {
                    return ucfirst($query->sholat);
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        }
        return view('sholat.umum');
    }

    public function sholatUmumAdd(Request $request)
    {
        if($request->ajax()){
            $query = JadwalSholatUmum::create([
                'tanggal'               => $request->tanggal,
                'sholat'                => $request->sholat,
                'imam'                  => $request->imam,
                'keterangan_imam'       => $request->keterangan_imam,
                'muazin'                => $request->muazin,
                'keterangan_muazin'     => $request->keterangan_muazin,
                'khatib'                => $request->khatib,
                'keterangan_khatib'     => $request->keterangan_khatib,
                'created_by'            => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    public function sholatUmumDelete(Request $request)
    {
        if($request->ajax()){
            JadwalSholatUmum::find($request->id)->delete($request->id);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }

    public function showSholatKhususPage(Request $request)
    {
        if($request->ajax()){
            $query = JadwalSholatKhusus::orderBy('tanggal', 'desc')->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($query) {
                    return $query->tanggal ? longdate_indo($query->tanggal) : '';
                })
                ->editColumn('sholat', function ($query) {
                    return ucfirst($query->sholat);
                })
                ->addColumn('created_by', function($query) {
                    return $query->user ? $query->user->name : 'NULL';
                })
                ->rawColumns(['action'])
                ->make(true);   
        }
        return view('sholat.khusus');
    }

    public function sholatKhususAdd(Request $request)
    {
        if($request->ajax()){
            $query = JadwalSholatKhusus::create([
                'tanggal'               => $request->tanggal,
                'time'                  => $request->time,
                'sholat'                => $request->sholat,
                'imam'                  => $request->imam,
                'keterangan_imam'       => $request->keterangan_imam,
                'muazin'                => $request->muazin,
                'keterangan_muazin'     => $request->keterangan_muazin,
                'khatib'                => $request->khatib,
                'keterangan_khatib'     => $request->keterangan_khatib,
                'created_by'            => auth()->user()->id,
            ]);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record Added successfully!'
            ]);
        }
    }

    public function sholatKhususDelete(Request $request)
    {
        if($request->ajax()){
            JadwalSholatKhusus::find($request->id)->delete($request->id);
            AppSetting::where('id', '1')->update(['revision_id' => uniqid()]);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
    }
    
}
